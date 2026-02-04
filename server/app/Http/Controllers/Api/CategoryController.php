<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Lấy danh sách tất cả categories
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Category::withCount('tours');
            
            // Lọc theo trạng thái
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }
            
            // Tìm kiếm theo tên category
            if ($request->has('search') && $request->search !== '') {
                $query->where(function($q) use ($request) {
                    $q->where('category_name', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
            
            // Sắp xếp
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Phân trang hoặc lấy tất cả
            if ($request->get('all') === 'true') {
                $categories = $query->get();
            } else {
                $perPage = $request->get('per_page', 10);
                $categories = $query->paginate($perPage);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách danh mục thành công',
                'data' => $categories
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy danh sách danh mục',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tạo category mới
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|max:255|unique:categories,category_name',
                'description' => 'nullable|string',
                'status' => 'nullable|in:active,inactive'
            ], [
                'category_name.required' => 'Tên danh mục là bắt buộc',
                'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
                'category_name.unique' => 'Tên danh mục đã tồn tại',
                'status.in' => 'Trạng thái không hợp lệ'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }

            $category = Category::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Tạo danh mục thành công',
                'data' => $category
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo danh mục',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin chi tiết category
     */
    public function show($id): JsonResponse
    {
        try {
            $category = Category::with(['tours' => function($query) {
                $query->select('tour_id', 'tour_name', 'price', 'status', 'category_id');
            }])->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy danh mục'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin danh mục thành công',
                'data' => $category
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy thông tin danh mục',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật category
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy danh mục'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'category_name' => 'sometimes|required|string|max:255|unique:categories,category_name,' . $id . ',category_id',
                'description' => 'nullable|string',
                'status' => 'nullable|in:active,inactive'
            ], [
                'category_name.required' => 'Tên danh mục là bắt buộc',
                'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
                'category_name.unique' => 'Tên danh mục đã tồn tại',
                'status.in' => 'Trạng thái không hợp lệ'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }

            $category->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật danh mục thành công',
                'data' => $category
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật danh mục',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa category
     */
    public function destroy($id): JsonResponse
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy danh mục'
                ], 404);
            }

            // Kiểm tra xem category có tour nào không
            $tourCount = $category->tours()->count();
            if ($tourCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa danh mục này vì đang có ' . $tourCount . ' tour thuộc danh mục này'
                ], 400);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa danh mục thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa danh mục',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Thay đổi trạng thái category
     */
    public function changeStatus(Request $request, $id): JsonResponse
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy danh mục'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:active,inactive'
            ], [
                'status.required' => 'Trạng thái là bắt buộc',
                'status.in' => 'Trạng thái không hợp lệ'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trạng thái không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }

            $category->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Thay đổi trạng thái danh mục thành công',
                'data' => $category
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thay đổi trạng thái danh mục',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}