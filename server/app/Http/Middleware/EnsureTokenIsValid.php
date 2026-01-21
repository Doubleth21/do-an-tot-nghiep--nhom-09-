<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Middleware kiểm tra token Sanctum hợp lệ
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Token được kiểm tra tự động bởi 'auth:sanctum' middleware
        // Middleware này chỉ là layer bổ sung nếu cần
        
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Token không hợp lệ hoặc đã hết hạn',
            ], 401);
        }

        return $next($request);
    }
}
