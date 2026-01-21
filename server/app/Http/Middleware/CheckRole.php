<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Middleware kiểm tra role của người dùng
     * 
     * Sử dụng: Route::middleware(['auth:sanctum', 'check.role:admin,tour_guide'])->group(...)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kiểm tra xem người dùng đã được xác thực hay không
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Chưa xác thực',
            ], 401);
        }

        // Kiểm tra xem role của người dùng có nằm trong danh sách role được phép hay không
        if (!in_array($request->user()->role, $roles)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập tài nguyên này',
            ], 403);
        }

        return $next($request);
    }
}
