<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DepartureSchedule;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartureScheduleController extends Controller
{
    // GET /api/departure-schedules?tour_id=&status=&from_date=&to_date=
    public function index(Request $request)
    {
        $query = DepartureSchedule::query()->with(['tour']);

        if ($request->filled('tour_id')) {
            $query->where('tour_id', (int) $request->query('tour_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('departure_date', '>=', $request->query('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('departure_date', '<=', $request->query('to_date'));
        }

        $schedules = $query->orderBy('departure_date')->get();

        return response()->json($schedules);
    }

    // GET /api/departure-schedules/{id}
    public function show($id)
    {
        $schedule = DepartureSchedule::with(['tour'])->find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Departure schedule not found'], 404);
        }

        return response()->json($schedule);
    }

    // POST /api/departure-schedules
    public function store(Request $request)
    {
        $data = $request->validate([
            'tour_id' => 'required|integer|exists:tour,tour_id',
            'departure_date' => [
                'required',
                'date',
                Rule::unique('departure_schedules', 'departure_date')
                    ->where(fn ($q) => $q->where('tour_id', $request->input('tour_id'))),
            ],
            'end_date' => 'nullable|date|after_or_equal:departure_date',
            'capacity' => 'required|integer|min:1|max:1000000',
            'booked' => 'nullable|integer|min:0|max:1000000',
            'price' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in(['open', 'closed', 'cancelled'])],
            'note' => 'nullable|string|max:2000',
        ]);

        $tour = Tour::find($data['tour_id']);
        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        $schedule = DepartureSchedule::create([
            'tour_id' => $data['tour_id'],
            'departure_date' => $data['departure_date'],
            'end_date' => $data['end_date'] ?? null,
            'capacity' => $data['capacity'],
            'booked' => $data['booked'] ?? 0,
            'price' => $data['price'] ?? null,
            'status' => $data['status'] ?? 'open',
            'note' => $data['note'] ?? null,
        ]);

        $schedule->load(['tour']);

        return response()->json($schedule, 201);
    }

    // PUT /api/departure-schedules/{id}
    public function update(Request $request, $id)
    {
        $schedule = DepartureSchedule::find($id);
        if (!$schedule) {
            return response()->json(['message' => 'Departure schedule not found'], 404);
        }

        $data = $request->validate([
            'tour_id' => 'sometimes|required|integer|exists:tour,tour_id',
            'departure_date' => 'sometimes|required|date',
            'end_date' => 'nullable|date',
            'capacity' => 'sometimes|required|integer|min:1|max:1000000',
            'booked' => 'sometimes|required|integer|min:0|max:1000000',
            'price' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in(['open', 'closed', 'cancelled'])],
            'note' => 'nullable|string|max:2000',
        ]);

        $tourId = $data['tour_id'] ?? $schedule->tour_id;
        $departureDate = $data['departure_date'] ?? $schedule->departure_date;

        if (isset($data['end_date']) && $data['end_date'] !== null) {
            if (strtotime($data['end_date']) < strtotime($departureDate)) {
                return response()->json([
                    'message' => 'end_date must be after or equal to departure_date',
                ], 422);
            }
        }

        $duplicate = DepartureSchedule::where('tour_id', $tourId)
            ->whereDate('departure_date', $departureDate)
            ->where('schedule_id', '!=', $schedule->schedule_id)
            ->exists();

        if ($duplicate) {
            return response()->json([
                'message' => 'Departure schedule already exists for this tour and date',
            ], 422);
        }

        $schedule->update($data);
        $schedule->load(['tour']);

        return response()->json($schedule);
    }

    // DELETE /api/departure-schedules/{id}
    public function destroy($id)
    {
        $schedule = DepartureSchedule::find($id);
        if (!$schedule) {
            return response()->json(['message' => 'Departure schedule not found'], 404);
        }

        $schedule->delete();

        return response()->json(null, 204);
    }

    // GET /api/tour/{tour_id}/departure-schedules
    public function byTour($tour_id)
    {
        $tour = Tour::find($tour_id);
        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        $schedules = DepartureSchedule::where('tour_id', $tour_id)
            ->with(['tour'])
            ->orderBy('departure_date')
            ->get();

        return response()->json($schedules);
    }
}

