<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    /**
     * Test API không cần database
     */
    public function test(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Backend Tour Management API đang hoạt động!',
            'data' => [
                'status' => 'OK',
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'features' => [
                    'Tour CRUD Management',
                    'Category Management', 
                    'Authentication & Authorization',
                    'File Upload Support',
                    'Search & Filter',
                    'Dashboard Statistics'
                ],
                'endpoints' => [
                    'GET /api/test' => 'Test API',
                    'GET /api/tours' => 'Public tours list',
                    'GET /api/categories' => 'Public categories list',
                    'POST /api/auth/login' => 'Admin login',
                    'GET /api/admin/tours' => 'Admin tours management',
                    'GET /api/admin/categories' => 'Admin categories management'
                ]
            ]
        ]);
    }

    /**
     * Test data mẫu tours
     */
    public function sampleTours(): JsonResponse
    {
        $sampleTours = [
            [
                'tour_id' => 1,
                'tour_name' => 'Tour Hạ Long Bay 2N1Đ',
                'description' => 'Khám phá vịnh Hạ Long với những hang động tuyệt đẹp',
                'price' => '1,500,000 VNĐ',
                'duration' => '2 ngày',
                'max_participants' => 20,
                'location' => 'Vịnh Hạ Long, Quảng Ninh',
                'status' => 'active',
                'category' => 'Du lịch biển'
            ],
            [
                'tour_id' => 2,
                'tour_name' => 'Trekking Sapa 3N2Đ',
                'description' => 'Leo núi Fansipan, khám phá bản làng dân tộc',
                'price' => '2,200,000 VNĐ',
                'duration' => '3 ngày',
                'max_participants' => 15,
                'location' => 'Sapa, Lào Cai',
                'status' => 'active',
                'category' => 'Du lịch núi'
            ],
            [
                'tour_id' => 3,
                'tour_name' => 'Khám phá Hội An - Huế 4N3Đ',
                'description' => 'Tham quan phố cổ Hội An, Đại Nội Huế',
                'price' => '3,500,000 VNĐ',
                'duration' => '4 ngày',
                'max_participants' => 25,
                'location' => 'Hội An - Huế',
                'status' => 'active',
                'category' => 'Du lịch văn hóa'
            ]
        ];

        return response()->json([
            'success' => true,
            'message' => 'Dữ liệu mẫu tours (không cần database)',
            'data' => [
                'current_page' => 1,
                'data' => $sampleTours,
                'total' => count($sampleTours),
                'per_page' => 10,
                'last_page' => 1
            ]
        ]);
    }

    /**
     * Test data mẫu categories
     */
    public function sampleCategories(): JsonResponse
    {
        $sampleCategories = [
            [
                'category_id' => 1,
                'category_name' => 'Du lịch biển',
                'description' => 'Các tour du lịch biển, nghỉ dưỡng tại các bãi biển đẹp',
                'status' => 'active',
                'tours_count' => 5
            ],
            [
                'category_id' => 2,
                'category_name' => 'Du lịch núi',
                'description' => 'Các tour leo núi, trekking, khám phá thiên nhiên',
                'status' => 'active',
                'tours_count' => 3
            ],
            [
                'category_id' => 3,
                'category_name' => 'Du lịch văn hóa',
                'description' => 'Khám phá văn hóa, lịch sử, di tích',
                'status' => 'active',
                'tours_count' => 4
            ]
        ];

        return response()->json([
            'success' => true,
            'message' => 'Dữ liệu mẫu categories (không cần database)',
            'data' => $sampleCategories
        ]);
    }
}