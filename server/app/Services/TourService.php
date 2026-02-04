<?php

namespace App\Services;

use App\Models\Tour;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class TourService
{
    /**
     * Get tours with filters and pagination
     */
    public function getTours(array $filters = [], int $perPage = 10)
    {
        $query = Tour::with(['category', 'creator:user_id,username,fullname']);
        
        $this->applyFilters($query, $filters);
        
        return $query->paginate($perPage);
    }

    /**
     * Create a new tour
     */
    public function createTour(array $data, ?UploadedFile $image = null): Tour
    {
        if ($image) {
            $data['image'] = $this->uploadImage($image);
        }

        $data['created_by'] = auth()->id();

        return Tour::create($data);
    }

    /**
     * Update tour
     */
    public function updateTour(Tour $tour, array $data, ?UploadedFile $image = null): Tour
    {
        if ($image) {
            // Delete old image
            if ($tour->image) {
                $this->deleteImage($tour->image);
            }
            
            $data['image'] = $this->uploadImage($image);
        }

        $tour->update($data);
        
        return $tour->fresh(['category', 'creator']);
    }

    /**
     * Delete tour
     */
    public function deleteTour(Tour $tour): bool
    {
        if ($tour->image) {
            $this->deleteImage($tour->image);
        }

        return $tour->delete();
    }

    /**
     * Upload tour image
     */
    private function uploadImage(UploadedFile $image): string
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        return $image->storeAs('tours', $imageName, 'public');
    }

    /**
     * Delete tour image
     */
    private function deleteImage(string $imagePath): bool
    {
        if (Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }
        
        return false;
    }

    /**
     * Apply filters to query
     */
    private function applyFilters(Builder $query, array $filters): void
    {
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('tour_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('location', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('start_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('end_date', '<=', $filters['end_date']);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get tour statistics
     */
    public function getTourStatistics(): array
    {
        return [
            'total_tours' => Tour::count(),
            'active_tours' => Tour::where('status', 'active')->count(),
            'inactive_tours' => Tour::where('status', 'inactive')->count(),
            'completed_tours' => Tour::where('status', 'completed')->count(),
            'cancelled_tours' => Tour::where('status', 'cancelled')->count(),
            'total_revenue' => Tour::where('status', 'completed')->sum('price'),
            'average_price' => Tour::where('status', 'active')->avg('price'),
        ];
    }
}