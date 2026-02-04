<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TourService;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    protected $tourService;
    protected $categoryService;

    public function __construct(TourService $tourService, CategoryService $categoryService)
    {
        $this->tourService = $tourService;
        $this->categoryService = $categoryService;
    }

    /**
     * Get dashboard statistics
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $tourStats = $this->tourService->getTourStatistics();
            $categoryStats = $this->categoryService->getCategoryStatistics();

            $data = [
                'tours' => $tourStats,
                'categories' => $categoryStats,
                'overview' => [
                    'total_tours' => $tourStats['total_tours'],
                    'total_categories' => $categoryStats['total_categories'],
                    'active_tours_percentage' => $tourStats['total_tours'] > 0 
                        ? round(($tourStats['active_tours'] / $tourStats['total_tours']) * 100, 2) 
                        : 0,
                    'average_price_formatted' => number_format($tourStats['average_price'] ?? 0, 0, ',', '.') . ' VNĐ',
                    'total_revenue_formatted' => number_format($tourStats['total_revenue'] ?? 0, 0, ',', '.') . ' VNĐ',
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Lấy thống kê thành công',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy thống kê',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}