<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/**
 * ============================================
 * AUTHENTICATION ROUTES (Không cần token)
 * ============================================
 */
Route::prefix('auth')->group(function () {
    // Đăng ký
    Route::post('/register', [AuthController::class, 'register']);
    
    // Đăng nhập
    Route::post('/login', [AuthController::class, 'login']);
});

/**
 * ============================================
 * PROTECTED ROUTES (Cần token Sanctum)
 * ============================================
 */
Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    // Lấy thông tin người dùng hiện tại
    Route::get('/me', [AuthController::class, 'me']);
    
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout']);
});

/**
 * ============================================
 * ADMIN & TOUR GUIDE ROUTES
 * ============================================
 * Yêu cầu token và role là admin hoặc tour_guide
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('check.role:admin,tour_guide')->group(function () {
        // Dashboard Statistics
        Route::get('admin/dashboard/statistics', [DashboardController::class, 'getStatistics']);
        
        // Category Management Routes
        Route::prefix('admin/categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::get('/{id}', [CategoryController::class, 'show']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
            Route::patch('/{id}/status', [CategoryController::class, 'changeStatus']);
        });

        // Tour Management Routes
        Route::prefix('admin/tours')->group(function () {
            Route::get('/', [TourController::class, 'index']);
            Route::post('/', [TourController::class, 'store']);
            Route::get('/{id}', [TourController::class, 'show']);
            Route::put('/{id}', [TourController::class, 'update']);
            Route::delete('/{id}', [TourController::class, 'destroy']);
            Route::patch('/{id}/status', [TourController::class, 'changeStatus']);
        });
    });
});

/**
 * ============================================
 * TEST ROUTES (Không cần database)
 * ============================================
 */
Route::get('test', [TestController::class, 'test']);
Route::get('test/tours', [TestController::class, 'sampleTours']);
Route::get('test/categories', [TestController::class, 'sampleCategories']);

/**
 * ============================================
 * PUBLIC ROUTES (Không cần authentication)
 * ============================================
 */
// Public categories (cho dropdown, filter, etc.)
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

// Public tours (cho trang chủ, danh sách tour công khai)
Route::get('tours', [TourController::class, 'index']);
Route::get('tours/{id}', [TourController::class, 'show']);

//Mặc định apiResource sẽ trỏ tới 5 phương thức mặc định trong controller api (index, show, update, store, destroy)
// Nếu tạo thêm các phương thức mới trong controller api thì cần phải khai báo thêm trong route
//Bắt buộc route đó phải đặt trên apiResource


