<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
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
            return response()->json(['message' => 'Tour not found'], 404);
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
            return response()->json(['message' => 'Tour not found'], 404);
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
            return response()->json(['message' => 'Tour not found'], 404);
        }

        $tour->delete();

        return response()->json(null, 204);
    }
}
