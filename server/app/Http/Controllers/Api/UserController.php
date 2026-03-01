<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng (trang admin). Phân trang.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $status = $request->query('status'); // optional filter: active, inactive, or omit for all

        $query = User::query();
        if (in_array($status, ['active','inactive'])) {
            $query->where('status', $status);
        }

        return response()->json($query->paginate($perPage));
    }

    /**
     * Lấy thông tin một người dùng theo id
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Cập nhật tài khoản (dành cho admin thay đổi role, status, hoặc cập nhật thông tin cơ bản)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'sometimes|required|string|min:3|max:255|unique:users,username,'.$user->user_id.',user_id',
            'email'    => 'sometimes|required|email|unique:users,email,'.$user->user_id.',user_id',
            'fullname' => 'sometimes|required|string|max:255',
            'phone'    => 'sometimes|required|string|max:20',
            'role'     => 'sometimes|required|in:'.implode(',', User::ROLE_LIST),
            'status'   => 'sometimes|required|in:active,inactive',
            'password' => 'sometimes|required|string|min:6',
        ]);

        // nếu admin thay đổi mật khẩu
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->fill($validated);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật người dùng thành công',
            'user' => $user,
        ], 200);
    }

    /**
     * "Xóa" người dùng – thực chất chỉ khoá/ẩn tài khoản bằng cách đặt status = inactive.
     *
     * Lý do: giữ bản ghi trong DB để có thể khôi phục hoặc liên kết dữ liệu còn nguyên.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Người dùng đã bị khoá (xóa mềm)',
        ], 200);
    }
}
