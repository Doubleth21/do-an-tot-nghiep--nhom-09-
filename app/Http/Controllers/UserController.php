<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function actor(Request $request): array
    {
        $role = $request->query('as_role') ?? $request->header('X-Role') ?? 'admin';
        $userId = $request->query('as_user_id') ?? $request->header('X-User-Id');
        return ['role' => $role, 'user_id' => $userId ? (int)$userId : null];
    }
    
    public function index(Request $request): JsonResponse
    {
        $accounts = User::query()->orderBy('user_id')->get();
        return response()->json([
            'ok' => true,
            'count' => $accounts->count(),
            'data' => $accounts,
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Không tìm thấy người dùng'], 404);
        }
        return response()->json(['ok' => true, 'data' => $user]);
    }

    // POST - Chỉ tour_guide được tạo mới tour_guide
    public function store(Request $request): JsonResponse
    {
        $actor = $this->actor($request);
        if ($actor['role'] !== 'tour_guide') {
            return response()->json(['ok' => false, 'message' => 'Chỉ role "tour_guide" mới được tạo mới'], 403);
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'max:255'],
            'fullname' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100'],
            'phone' => ['nullable', 'string', 'max:15'],
            'status' => ['nullable', Rule::in(['active','inactive'])],
        ]);

        $user = new User();
        $user->username = $validated['username'];
        $user->password = Hash::make($validated['password']); 
        $user->fullname = $validated['fullname'];
        $user->email = $validated['email'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->role = 'tour_guide';
        $user->status = $validated['status'] ?? 'active';
        $user->save();

        return response()->json(['ok' => true, 'data' => $user], 201);
    }

    // PATCH/PUT - Chỉ tour_guide được cập nhật tài khoản tour_guide khác
    public function update(Request $request, int $id): JsonResponse
    {
        $actor = $this->actor($request);
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Không tìm thấy người dùng'], 404);
        }

        if ($actor['role'] === 'admin') {
            $validated = $request->validate([
                'username' => ['sometimes', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
                'password' => ['sometimes', 'string', 'max:255'],
                'fullname' => ['sometimes', 'string', 'max:100'],
                'email' => ['sometimes', 'nullable', 'email', 'max:100'],
                'phone' => ['sometimes', 'nullable', 'string', 'max:15'],
                'role' => ['sometimes', Rule::in(['admin','tour_guide','user'])],
                'status' => ['sometimes', Rule::in(['active','inactive'])],
            ]);
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            $user->fill($validated);
            $user->save();
            return response()->json(['ok' => true, 'data' => $user]);
        }

        if ($actor['role'] === 'user') {
            if (!$actor['user_id'] || $actor['user_id'] !== (int)$user->user_id) {
                return response()->json(['ok' => false, 'message' => 'Chỉ role "tour_guide" mới được cập nhật '], 403);
            }
            $validated = $request->validate([
                'fullname' => ['required', 'string', 'max:100'],
            ]);
            $user->fullname = $validated['fullname'];
            $user->save();
            return response()->json(['ok' => true, 'data' => $user]);
        }

        if ($actor['role'] === 'tour_guide') {
            if ($user->role !== 'tour_guide') {
                return response()->json(['ok' => false, 'message' => 'Chỉ role "tour_guide" mới được cập nhật tài khoản role "tour_guide"'], 403);
            }
            $validated = $request->validate([
                'username' => ['sometimes', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
                'password' => ['sometimes', 'string', 'max:255'],
                'fullname' => ['sometimes', 'string', 'max:100'],
                'email' => ['sometimes', 'nullable', 'email', 'max:100'],
                'phone' => ['sometimes', 'nullable', 'string', 'max:15'],
                'status' => ['sometimes', Rule::in(['active','inactive'])],
            ]);
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            $user->fill($validated);
            $user->save();
            return response()->json(['ok' => true, 'data' => $user]);
        }

        return response()->json(['ok' => false, 'message' => 'Role không hợp lệ'], 400);
    }

    // DELETE - Chỉ tour_guide được xóa
    public function destroy(Request $request, int $id): JsonResponse
    {
        $actor = $this->actor($request);
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Không tìm thấy người dùng'], 404);
        }

        if ($actor['role'] !== 'tour_guide') {
            return response()->json(['ok' => false, 'message' => 'Chỉ role "tour_guide" mới được xóa'], 403);
        }

        if ($user->role !== 'tour_guide') {
            return response()->json(['ok' => false, 'message' => 'Chỉ xóa được role "tour_guide"'], 403);
        }

        $user->delete();
        return response()->json(['ok' => true, 'message' => 'Xóa thành công']);
    }
}