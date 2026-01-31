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
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user && $user->role === 'admin') {
            // Admin xem tất cả booking
            $bookings = Booking::with(['user', 'tour'])->get();
        } else {
            // User chỉ xem booking của mình
            $bookings = Booking::where('user_id', $user->user_id)
                ->with(['user', 'tour'])
                ->get();
        }
        
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
        $user = auth()->user();
        if ($user->role !== 'admin' && $booking->user_id !== $user->user_id) {
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

        $user = auth()->user();
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

        $user = auth()->user();
        
        // Chỉ chủ booking hoặc admin mới cập nhật được
        if ($user->role !== 'admin' && $booking->user_id !== $user->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1|max:100',
            'status' => 'sometimes|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:500',
            'travel_date' => 'nullable|date|after_or_equal:today',
        ]);

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

    // DELETE /api/booking/{id} - Xóa booking
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $user = auth()->user();
        
        // Chỉ chủ booking hoặc admin mới xóa được
        if ($user->role !== 'admin' && $booking->user_id !== $user->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Chỉ được xóa booking với status pending hoặc cancelled
        if (!in_array($booking->status, ['pending', 'cancelled'])) {
            return response()->json([
                'message' => 'Cannot delete booking with status ' . $booking->status
            ], 400);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }

    // GET /api/booking/user/{user_id} - Lấy tất cả booking của 1 user (Admin only)
    public function userBookings($user_id)
    {
        $user = auth()->user();
        
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookings = Booking::where('user_id', $user_id)
            ->with(['user', 'tour'])
            ->get();

        return response()->json($bookings);
    }

    // GET /api/booking/tour/{tour_id} - Lấy tất cả booking của 1 tour (Admin/TourGuide only)
    public function tourBookings($tour_id)
    {
        $user = auth()->user();
        
        if (!in_array($user->role, ['admin', 'tour_guide'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookings = Booking::where('tour_id', $tour_id)
            ->with(['user', 'tour'])
            ->get();

        return response()->json($bookings);
    }
}
