<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TourController;
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
        // Admin routes sẽ được thêm ở đây
        // Quản lý Tour (Admin / Tour Guide)
        Route::apiResource('tour', TourController::class);
    });
});

//Mặc định apiResource sẽ trỏ tới 5 phương thức mặc định trong controller api (index, show, update, store, destroy)
// Nếu tạo thêm các phương thức mới trong controller api thì cần phải khai báo thêm trong route
//Bắt buộc route đó phải đặt trên apiResource


