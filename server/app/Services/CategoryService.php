<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryService
{
    /**
     * Get categories with filters and pagination
     */
    public function getCategories(array $filters = [], int $perPage = 10, bool $all = false)
    {
        $query = Category::withCount('tours');
        
        $this->applyFilters($query, $filters);
        
        if ($all) {
            return $query->get();
        }
        
        return $query->paginate($perPage);
    }

    /**
     * Create a new category
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
        
        return $category->fresh();
    }

    /**
     * Delete category
     */
    public function deleteCategory(Category $category): bool
    {
        // Check if category has tours
        if ($category->tours()->count() > 0) {
            throw new \Exception('Không thể xóa danh mục này vì đang có tour thuộc danh mục này');
        }

        return $category->delete();
    }

    /**
     * Apply filters to query
     */
    private function applyFilters(Builder $query, array $filters): void
    {
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('category_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Get category statistics
     */
    public function getCategoryStatistics(): array
    {
        return [
            'total_categories' => Category::count(),
            'active_categories' => Category::where('status', 'active')->count(),
            'inactive_categories' => Category::where('status', 'inactive')->count(),
            'categories_with_tours' => Category::has('tours')->count(),
            'categories_without_tours' => Category::doesntHave('tours')->count(),
        ];
    }
}