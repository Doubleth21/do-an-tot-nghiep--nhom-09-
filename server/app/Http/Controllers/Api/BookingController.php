<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    // GET /api/booking - Lấy tất cả booking (admin xem tất cả, user xem của mình)
    // Optional query parameter `status` to filter by booking.status
    public function index(Request $request)
    {
        // Dự án đang dùng Sanctum với guard auth:sanctum => lấy user qua $request->user()
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $status = $request->query('status'); // pending, confirmed, cancel_requested, cancelled, completed

        $query = Booking::with(['user', 'tour']);
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->user_id);
        }

        if (in_array($status, ['pending', 'confirmed', 'cancel_requested', 'cancelled', 'completed'], true)) {
            $query->where('status', $status);
        }

        $bookings = $query->get();
        return response()->json($bookings);
    }

    // GET /api/booking/{id} - Lấy chi tiết 1 booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'tour'])->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Kiểm tra quyền: chỉ chủ booking hoặc admin mới xem được
        $user = request()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($user->role !== 'admin' && (int) $booking->user_id !== (int) $user->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($booking);
    }

    // POST /api/booking - Tạo booking mới (đặt tour)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tour,tour_id',
            'quantity' => 'required|integer|min:1|max:100',
            'notes' => 'nullable|string|max:500',
            'travel_date' => 'nullable|date|after_or_equal:today',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $tour = Tour::find($validated['tour_id']);
        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        // Tính tổng giá
        $total_price = $tour->price * $validated['quantity'];

        $booking = Booking::create([
            'user_id' => $user->user_id,
            'tour_id' => $validated['tour_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $total_price,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'booking_date' => Carbon::now(),
            'travel_date' => $validated['travel_date'] ?? null,
        ]);

        // Load relationship
        $booking->load(['user', 'tour']);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    // PUT/PATCH /api/booking/{id} - Cập nhật booking
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Chỉ chủ booking hoặc admin mới cập nhật được
        if ($user->role !== 'admin' && (int) $booking->user_id !== (int) $user->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // validation khác nhau cho admin và user
        if ($user->role === 'admin') {
            $validated = $request->validate([
                'quantity' => 'sometimes|integer|min:1|max:100',
                'status' => 'sometimes|in:pending,confirmed,cancel_requested,cancelled,completed',
                'notes' => 'nullable|string|max:500',
                'travel_date' => 'nullable|date|after_or_equal:today',
            ]);
        } else {
            // User thường chỉ được sửa thông tin và không được tự đổi trạng thái
            $validated = $request->validate([
                'quantity' => 'sometimes|integer|min:1|max:100',
                'notes' => 'nullable|string|max:500',
                'travel_date' => 'nullable|date|after_or_equal:today',
            ]);
        }

        // Nếu cập nhật quantity, tính lại total_price
        if (isset($validated['quantity'])) {
            $tour = $booking->tour;
            $validated['total_price'] = $tour->price * $validated['quantity'];
        }

        $booking->update($validated);
        $booking->load(['user', 'tour']);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ]);
    }

    /**
     * POST /api/booking/{id}/cancel-request - Người dùng gửi yêu cầu huỷ
     */
    public function requestCancel($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $user = request()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ((int) $booking->user_id !== (int) $user->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // chỉ được gửi yêu cầu khi đang ở trạng thái pending hoặc confirmed
        if (!in_array($booking->status, ['pending', 'confirmed'], true)) {
            return response()->json([
                'message' => 'Cannot request cancellation when status is ' . $booking->status
            ], 400);
        }

        $booking->status = 'cancel_requested';
        $booking->save();
        $booking->load(['user','tour']);

        return response()->json([
            'message' => 'Cancellation requested',
            'booking' => $booking
        ], 200);
    }

    // DELETE /api/booking/{id} - Xóa booking
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $user = request()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Chỉ chủ booking hoặc admin mới xóa được
        if ($user->role !== 'admin' && (int) $booking->user_id !== (int) $user->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Chỉ được xóa booking với status pending hoặc cancelled
        if (!in_array($booking->status, ['pending', 'cancelled'], true)) {
            return response()->json([
                'message' => 'Cannot delete booking with status ' . $booking->status
            ], 400);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }

    // GET /api/user/{user_id}/bookings - Lấy tất cả booking của 1 user (Admin only)
    public function userBookings($user_id)
    {
        $user = request()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookings = Booking::where('user_id', $user_id)
            ->with(['user', 'tour'])
            ->get();

        return response()->json($bookings);
    }

    // GET /api/tour/{tour_id}/bookings - Lấy tất cả booking của 1 tour (Admin/TourGuide only)
    public function tourBookings($tour_id)
    {
        $user = request()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!in_array($user->role, ['admin', 'tour_guide'], true)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookings = Booking::where('tour_id', $tour_id)
            ->with(['user', 'tour'])
            ->get();

        return response()->json($bookings);
    }
}
