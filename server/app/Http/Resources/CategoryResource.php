<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'description' => $this->description,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'tours_count' => $this->whenCounted('tours'),
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),
            
            // Relationships
            'tours' => TourResource::collection($this->whenLoaded('tours')),
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
            default => 'Không xác định'
        };
    }
}