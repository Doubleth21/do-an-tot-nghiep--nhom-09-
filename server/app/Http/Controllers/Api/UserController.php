<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Danh sách người dùng (phân trang, filter theo status)
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $status = $request->query('status'); // active | inactive | null

        $query = User::query();
        if (in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        return response()->json($query->paginate($perPage));
    }

    /**
     * Xem chi tiết 1 người dùng
     */
    public function show(int $id): JsonResponse
    {
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Không tìm thấy người dùng'], 404);
        }
        return response()->json(['ok' => true, 'data' => $user]);
    }

    /**
     * Tạo mới tài khoản (yêu cầu đã đăng nhập; chỉ admin hoặc tour_guide)
     * Mặc định tạo tài khoản role = tour_guide
     */
    public function store(Request $request): JsonResponse
    {
        $actor = $request->user();
        if (!$actor) {
            return response()->json(['ok' => false, 'message' => 'Chưa xác thực'], 401);
        }
        if (!in_array($actor->role, ['admin', 'tour_guide'], true)) {
            return response()->json(['ok' => false, 'message' => 'Bạn không có quyền tạo tài khoản'], 403);
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
            'fullname' => ['required', 'string', 'max:100'],
            'email'    => ['nullable', 'email', 'max:100'],
            'phone'    => ['nullable', 'string', 'max:15'],
            'status'   => ['nullable', Rule::in(['active', 'inactive'])],
        ]);

        $user = new User();
        $user->username = $validated['username'];
        $user->password = Hash::make($validated['password']);
        $user->fullname = $validated['fullname'];
        $user->email    = $validated['email'] ?? null;
        $user->phone    = $validated['phone'] ?? null;
        $user->role     = 'tour_guide';
        $user->status   = $validated['status'] ?? 'active';
        $user->save();

        return response()->json(['ok' => true, 'data' => $user], 201);
    }

    /**
     * Cập nhật tài khoản.
     * - admin: cập nhật mọi người dùng; có thể đổi role/status
     * - tour_guide: chỉ được cập nhật tài khoản role=tour_guide; không đổi role
     * - user: chỉ được tự cập nhật fullname của chính mình
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $actor = $request->user();
        if (!$actor) {
            return response()->json(['ok' => false, 'message' => 'Chưa xác thực'], 401);
        }

        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Không tìm thấy người dùng'], 404);
        }

        if ($actor->role === 'admin') {
            $validated = $request->validate([
                'username' => ['sometimes', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
                'password' => ['sometimes', 'string', 'min:6', 'max:255'],
                'fullname' => ['sometimes', 'string', 'max:100'],
                'email'    => ['sometimes', 'nullable', 'email', 'max:100'],
                'phone'    => ['sometimes', 'nullable', 'string', 'max:15'],
                'role'     => ['sometimes', Rule::in(['admin','tour_guide','user'])],
                'status'   => ['sometimes', Rule::in(['active','inactive'])],
            ]);
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            $user->fill($validated);
            $user->save();
            return response()->json(['ok' => true, 'data' => $user]);
        }

        if ($actor->role === 'user') {
            if ((int)$actor->user_id !== (int)$user->user_id) {
                return response()->json(['ok' => false, 'message' => 'Không có quyền cập nhật người dùng khác'], 403);
            }
            $validated = $request->validate([
                'fullname' => ['required', 'string', 'max:100'],
            ]);
            $user->fullname = $validated['fullname'];
            $user->save();
            return response()->json(['ok' => true, 'data' => $user]);
        }

        if ($actor->role === 'tour_guide') {
            if ($user->role !== 'tour_guide') {
                return response()->json(['ok' => false, 'message' => 'Chỉ cập nhật được tài khoản role "tour_guide"'], 403);
            }
            $validated = $request->validate([
                'username' => ['sometimes', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
                'password' => ['sometimes', 'string', 'min:6', 'max:255'],
                'fullname' => ['sometimes', 'string', 'max:100'],
                'email'    => ['sometimes', 'nullable', 'email', 'max:100'],
                'phone'    => ['sometimes', 'nullable', 'string', 'max:15'],
                'status'   => ['sometimes', Rule::in(['active','inactive'])],
            ]);
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            // Không cho sửa role
            unset($validated['role']);

            $user->fill($validated);
            $user->save();
            return response()->json(['ok' => true, 'data' => $user]);
        }

        return response()->json(['ok' => false, 'message' => 'Role không hợp lệ'], 400);
    }

    /**
     * Khoá tài khoản (soft) bằng cách đặt status = inactive
     * - admin: có thể khoá bất kỳ
     * - tour_guide: chỉ khoá được tài khoản tour_guide
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $actor = $request->user();
        if (!$actor) {
            return response()->json(['ok' => false, 'message' => 'Chưa xác thực'], 401);
        }

        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Không tìm thấy người dùng'], 404);
        }

        if ($actor->role === 'admin') {
            $user->status = 'inactive';
            $user->save();
            return response()->json(['ok' => true, 'message' => 'Đã khoá tài khoản (inactive)']);
        }

        if ($actor->role === 'tour_guide') {
            if ($user->role !== 'tour_guide') {
                return response()->json(['ok' => false, 'message' => 'Chỉ khoá được tài khoản role "tour_guide"'], 403);
            }
            $user->status = 'inactive';
            $user->save();
            return response()->json(['ok' => true, 'message' => 'Đã khoá tài khoản (inactive)']);
        }

        return response()->json(['ok' => false, 'message' => 'Bạn không có quyền khoá tài khoản này'], 403);
    }
}
