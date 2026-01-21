<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Đăng ký người dùng mới
     */
    public function register(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ], [
            'username.required' => 'Tên người dùng là bắt buộc',
            'username.min' => 'Tên người dùng phải ít nhất 3 ký tự',
            'username.unique' => 'Tên người dùng đã tồn tại',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được đăng ký',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự',
            'fullname.required' => 'Họ và tên là bắt buộc',
            'phone.required' => 'Số điện thoại là bắt buộc',
        ]);

        try {
            // Tạo người dùng mới với role mặc định là 'user'
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'fullname' => $validated['fullname'],
                'phone' => $validated['phone'],
                'role' => User::ROLE_USER,
            ]);

            // Tạo token cho người dùng
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Đăng ký thành công',
                'user' => $user,
                'token' => $token,
                'redirect' => '/', // Hướng đến trang chủ
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi đăng ký: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Đăng nhập người dùng
     */
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu là bắt buộc',
        ]);

        // Tìm người dùng bằng email
        $user = User::where('email', $validated['email'])->first();

        // Kiểm tra xem người dùng có tồn tại và mật khẩu có đúng không
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không chính xác',
            ], 401);
        }

        try {
            // Tạo token cho người dùng
            $token = $user->createToken('auth_token')->plainTextToken;

            // Xác định trang điều hướng dựa trên role
            $redirect = $this->getRedirectPath($user->role);

            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'user' => $user,
                'token' => $token,
                'redirect' => $redirect,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi đăng nhập: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Đăng xuất người dùng
     */
    public function logout(Request $request)
    {
        try {
            // Xóa token hiện tại
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đăng xuất thành công',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi đăng xuất: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lấy thông tin người dùng hiện tại
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ], 200);
    }

    /**
     * Xác định trang điều hướng dựa trên role của người dùng
     */
    private function getRedirectPath($role)
    {
        return match ($role) {
            User::ROLE_ADMIN, User::ROLE_TOUR_GUIDE => '/admin',
            User::ROLE_USER => '/',
            default => '/',
        };
    }
}
