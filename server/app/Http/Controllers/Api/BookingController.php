<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    // GET /api/booking - Lấy tất cả booking (admin xem tất cả)
    public function index(Request $request)
    {
        $user = auth('sanctum')->user();

        if ($user && in_array($user->role, ['admin', 'tour_guide'])) {
            // Admin/Tour Guide xem tất cả booking
            $bookings = Booking::with(['customer', 'tour', 'schedule'])->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($bookings);
    }

    // GET /api/booking/{id} - Lấy chi tiết 1 booking
    public function show($id)
    {
        $booking = Booking::with(['customer', 'tour', 'schedule'])->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking);
    }

    // POST /api/booking - Tạo booking mới (đặt tour)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customer,customer_id',
            'tour_id' => 'required|exists:tour,tour_id',
            'schedule_id' => 'required|exists:departure_schedule,schedule_id',
            'num_people' => 'required|integer|min:1|max:100',
            'note' => 'nullable|string|max:500',
        ]);

        $tour = Tour::find($validated['tour_id']);

        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        // Tính tổng giá
        $total_price = $tour->price * $validated['num_people'];

        $booking = Booking::create([
            'customer_id' => $validated['customer_id'],
            'tour_id' => $validated['tour_id'],
            'schedule_id' => $validated['schedule_id'],
            'num_people' => $validated['num_people'],
            'total_price' => $total_price,
            'status' => 'upcoming',
            'payment_status' => 'unpaid',
            'note' => $validated['note'] ?? null,
            'booking_date' => Carbon::now(),
        ]);

        // Load relationship
        $booking->load(['customer', 'tour', 'schedule']);

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

        $validated = $request->validate([
            'num_people' => 'sometimes|integer|min:1|max:100',
            'status' => 'sometimes|in:upcoming,ongoing,completed,cancelled',
            'payment_status' => 'sometimes|in:unpaid,deposit,paid',
            'note' => 'nullable|string|max:500',
        ]);

        // Nếu cập nhật num_people, tính lại total_price
        if (isset($validated['num_people'])) {
            $tour = $booking->tour;
            $validated['total_price'] = $tour->price * $validated['num_people'];
        }

        $booking->update($validated);
        $booking->load(['customer', 'tour', 'schedule']);

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

        // Chỉ được xóa booking với status upcoming hoặc cancelled
        if (!in_array($booking->status, ['upcoming', 'cancelled'])) {
            return response()->json([
                'message' => 'Cannot delete booking with status ' . $booking->status
            ], 400);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }

    // GET /api/customer/{customer_id}/bookings - Lấy tất cả booking của 1 customer (Admin only)
    public function customerBookings($customer_id)
    {
        $user = auth('sanctum')->user();

        if (!in_array($user->role, ['admin', 'tour_guide'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookings = Booking::where('customer_id', $customer_id)
            ->with(['customer', 'tour', 'schedule'])
            ->get();

        return response()->json($bookings);
    }

    // GET /api/tour/{tour_id}/bookings - Lấy tất cả booking của 1 tour (Admin/TourGuide only)
    public function tourBookings($tour_id)
    {
        $user = auth('sanctum')->user();

        if (!in_array($user->role, ['admin', 'tour_guide'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookings = Booking::where('tour_id', $tour_id)
            ->with(['customer', 'tour', 'schedule'])
            ->get();

        return response()->json($bookings);
    }
}
