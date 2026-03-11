<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

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
        // Hỗ trợ đăng nhập bằng email hoặc username
        $validated = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email hoặc username là bắt buộc',
            'password.required' => 'Mật khẩu là bắt buộc',
        ]);

        $login = $validated['login'];

        // Nếu login là email hợp lệ thì tìm theo email, ngược lại tìm theo username
        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $login)->first()
            : User::where('username', $login)->first();

        // Kiểm tra mật khẩu.
        // DB hiện có dữ liệu legacy lưu plain-text (ví dụ "123456"), Hash::check sẽ throw RuntimeException
        // "This password does not use the Bcrypt algorithm". Vì vậy xử lý an toàn:
        // - Nếu password đã là hash: dùng Hash::check
        // - Nếu password là plain-text: so sánh trực tiếp và re-hash lại để chuẩn hoá dữ liệu
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin đăng nhập hoặc mật khẩu không chính xác',
            ], 401);
        }

        $passwordOk = false;
        try {
            $passwordOk = Hash::check($validated['password'], $user->password);
        } catch (\RuntimeException $e) {
            $passwordOk = false;
        }

        if (!$passwordOk) {
            // Fallback cho dữ liệu legacy (plain-text)
            if (hash_equals((string) $user->password, (string) $validated['password'])) {
                $passwordOk = true;

                // Chuẩn hoá: hash lại mật khẩu theo bcrypt để lần sau login không lỗi nữa
                $user->password = Hash::make($validated['password']);
                $user->save();
            }
        }

        if (!$passwordOk) {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin đăng nhập hoặc mật khẩu không chính xác',
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
     * Cập nhật thông tin cá nhân của người dùng (username, email, fullname, phone)
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Validation, bỏ qua chính bản thân khi kiểm tra unique
        $validated = $request->validate([
            'username' => 'sometimes|required|string|min:3|max:255|unique:users,username,'.$user->user_id.',user_id',
            'email'    => 'sometimes|required|email|unique:users,email,'.$user->user_id.',user_id',
            'fullname' => 'sometimes|required|string|max:255',
            'phone'    => 'sometimes|required|string|max:20',
        ]);

        $user->fill($validated);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công',
            'user' => $user,
        ], 200);
    }

    /**
     * Thay đổi mật khẩu hiện tại
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:6|confirmed',
        ]);

        // kiểm tra mật khẩu hiện tại
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu hiện tại không đúng',
            ], 422);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công',
        ], 200);
    }

    /**
     * Xác định trang điều hướng dựa trên role của người dùng
     */
    private function getRedirectPath($role)
    {
        return match ($role) {
            User::ROLE_ADMIN => '/admin',
            User::ROLE_TOUR_GUIDE => '/tourguide',
            User::ROLE_USER => '/',
            default => '/',
        };
    }
}
