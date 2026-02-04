<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tour_id' => $this->tour_id,
            'tour_name' => $this->tour_name,
            'description' => $this->description,
            'price' => number_format($this->price, 0, ',', '.') . ' VNĐ',
            'price_raw' => $this->price,
            'duration' => $this->duration,
            'duration_text' => $this->duration . ' ngày',
            'max_participants' => $this->max_participants,
            'start_date' => $this->start_date?->format('d/m/Y H:i'),
            'start_date_raw' => $this->start_date,
            'end_date' => $this->end_date?->format('d/m/Y H:i'),
            'end_date_raw' => $this->end_date,
            'location' => $this->location,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'image_path' => $this->image,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'category_id' => $this->category_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),
            
            // Relationships
            'category' => new CategoryResource($this->whenLoaded('category')),
            'creator' => $this->whenLoaded('creator', function () {
                return [
                    'user_id' => $this->creator->user_id,
                    'username' => $this->creator->username,
                    'fullname' => $this->creator->fullname,
                ];
            }),
        ];
    }

    /**
     * Get status text in Vietnamese
     */
    private function getStatusText(): string
    {
        return match($this->status) {
            'active' => 'Đang hoạt động',
            'inactive' => 'Tạm ngưng',
            'completed' => 'Đã hoàn thành',
            'cancelled' => 'Đã hủy',
            default => 'Không xác định'
        };
    }
}