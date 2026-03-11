<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    /**
     * GET /api/tour/my
     * Hướng dẫn viên xem danh sách tour được phân công (qua bảng tour_guides)
     */
    public function myTours(Request $request): JsonResponse
    {
        $actor = $request->user();

        if (!$actor) {
            return response()->json([
                'ok' => false,
                'message' => 'Chưa xác thực'
            ], 401);
        }

        if ($actor->role !== 'tour_guide') {
            return response()->json([
                'ok' => false,
                'message' => 'Chỉ hướng dẫn viên mới xem được'
            ], 403);
        }

        $perPage = (int) $request->query('per_page', 15);

        $query = Tour::with('guides')
            ->whereHas('guides', function ($q) use ($actor) {
                $q->where('users.user_id', $actor->user_id);
            });

        return response()->json([
            'ok' => true,
            'data' => $query->paginate($perPage)
        ]);
    }
    // GET /api/tour
    public function index()
    {
        $tours = Tour::all();
        return response()->json($tours);
    }

    // GET /api/tour/{id}
    public function show($id)
    {
        $tour = Tour::find($id);
        if (!$tour) {
            return response()->json(['message' => 'Không tìm thấy tour'], 404);
        }
        return response()->json($tour);
    }

    // POST /api/tour
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'policy' => 'nullable|string',
            'supplier' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
            'price' => 'required|numeric',
        ]);

        $tour = Tour::create($data);

        return response()->json($tour, 201);
    }

    // PUT /api/tour/{id}
    public function update(Request $request, $id)
    {
        $tour = Tour::find($id);
        if (!$tour) {
            return response()->json(['message' => 'Không tìm thấy tour'], 404);
        }

        $data = $request->validate([
            'category_id' => 'nullable|integer',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'policy' => 'nullable|string',
            'supplier' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
            'price' => 'sometimes|required|numeric',
        ]);

        $tour->update($data);

        return response()->json($tour);
    }

    // DELETE /api/tour/{id}
    public function destroy($id)
    {
        $tour = Tour::find($id);
        if (!$tour) {
            return response()->json(['message' => 'Không tìm thấy tour'], 404);
        }

        $tour->delete();

        return response()->json(null, 204);
    }
}
