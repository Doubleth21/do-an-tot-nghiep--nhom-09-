<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// JSON endpoints for quản lý tài khoản (test bằng JSON)
Route::prefix('admin/accounts')->group(function () {
    Route::get('/', [UserController::class, 'index']); // Xem danh sách
    Route::get('/{id}', [UserController::class, 'show']); // Xem chi tiết
    Route::post('/', [UserController::class, 'store']); // tour_guide: thêm tour_guide
    Route::match(['put','patch'], '/{id}', [UserController::class, 'update']); // cập nhật theo role
    Route::delete('/{id}', [UserController::class, 'destroy']); // xóa theo role
});


