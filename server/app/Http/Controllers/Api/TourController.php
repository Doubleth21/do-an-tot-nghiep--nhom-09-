<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    /**
     * Lấy danh sách tất cả tours
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Tour::with(['category', 'creator:user_id,username,fullname']);
            
            // Lọc theo trạng thái
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }
            
            // Lọc theo category
            if ($request->has('category_id') && $request->category_id !== '') {
                $query->where('category_id', $request->category_id);
            }
            
            // Tìm kiếm theo tên tour
            if ($request->has('search') && $request->search !== '') {
                $query->where(function($q) use ($request) {
                    $q->where('tour_name', 'like', '%' . $request->search . '%')
                      ->orWhere('location', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
            
            // Lọc theo giá
            if ($request->has('price_min') && $request->price_min !== '') {
                $query->where('price', '>=', $request->price_min);
            }
            
            if ($request->has('price_max') && $request->price_max !== '') {
                $query->where('price', '<=', $request->price_max);
            }
            
            // Lọc theo ngày
            if ($request->has('start_date') && $request->start_date !== '') {
                $query->whereDate('start_date', '>=', $request->start_date);
            }
            
            if ($request->has('end_date') && $request->end_date !== '') {
                $query->whereDate('end_date', '<=', $request->end_date);
            }
            
            // Sắp xếp
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Phân trang
            $perPage = $request->get('per_page', 10);
            $tours = $query->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách tour thành công',
                'data' => $tours
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy danh sách tour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tạo tour mới
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'tour_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'duration' => 'required|integer|min:1',
                'max_participants' => 'required|integer|min:1',
                'start_date' => 'required|date|after:today',
                'end_date' => 'required|date|after:start_date',
                'location' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,category_id',
                'status' => 'nullable|in:active,inactive'
            ], [
                'tour_name.required' => 'Tên tour là bắt buộc',
                'tour_name.max' => 'Tên tour không được vượt quá 255 ký tự',
                'price.required' => 'Giá tour là bắt buộc',
                'price.numeric' => 'Giá tour phải là số',
                'price.min' => 'Giá tour phải lớn hơn hoặc bằng 0',
                'duration.required' => 'Thời gian tour là bắt buộc',
                'duration.integer' => 'Thời gian tour phải là số nguyên',
                'duration.min' => 'Thời gian tour phải ít nhất 1 ngày',
                'max_participants.required' => 'Số lượng tham gia tối đa là bắt buộc',
                'max_participants.integer' => 'Số lượng tham gia phải là số nguyên',
                'max_participants.min' => 'Số lượng tham gia phải ít nhất 1 người',
                'start_date.required' => 'Ngày bắt đầu là bắt buộc',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ',
                'start_date.after' => 'Ngày bắt đầu phải sau ngày hôm nay',
                'end_date.required' => 'Ngày kết thúc là bắt buộc',
                'end_date.date' => 'Ngày kết thúc không hợp lệ',
                'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
                'location.required' => 'Địa điểm là bắt buộc',
                'location.max' => 'Địa điểm không được vượt quá 255 ký tự',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
                'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
                'category_id.exists' => 'Danh mục không tồn tại',
                'status.in' => 'Trạng thái không hợp lệ'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tourData = $request->all();
            $tourData['created_by'] = auth()->id();

            // Xử lý upload ảnh
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('tours', $imageName, 'public');
                $tourData['image'] = $imagePath;
            }

            $tour = Tour::create($tourData);
            $tour->load(['category', 'creator:user_id,username,fullname']);

            return response()->json([
                'success' => true,
                'message' => 'Tạo tour thành công',
                'data' => $tour
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo tour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin chi tiết tour
     */
    public function show($id): JsonResponse
    {
        try {
            $tour = Tour::with(['category', 'creator:user_id,username,fullname'])
                       ->find($id);

            if (!$tour) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy tour'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin tour thành công',
                'data' => $tour
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy thông tin tour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật tour
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $tour = Tour::find($id);

            if (!$tour) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy tour'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'tour_name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'duration' => 'sometimes|required|integer|min:1',
                'max_participants' => 'sometimes|required|integer|min:1',
                'start_date' => 'sometimes|required|date',
                'end_date' => 'sometimes|required|date|after:start_date',
                'location' => 'sometimes|required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|exists:categories,category_id',
                'status' => 'nullable|in:active,inactive,completed,cancelled'
            ], [
                'tour_name.required' => 'Tên tour là bắt buộc',
                'tour_name.max' => 'Tên tour không được vượt quá 255 ký tự',
                'price.required' => 'Giá tour là bắt buộc',
                'price.numeric' => 'Giá tour phải là số',
                'price.min' => 'Giá tour phải lớn hơn hoặc bằng 0',
                'duration.required' => 'Thời gian tour là bắt buộc',
                'duration.integer' => 'Thời gian tour phải là số nguyên',
                'duration.min' => 'Thời gian tour phải ít nhất 1 ngày',
                'max_participants.required' => 'Số lượng tham gia tối đa là bắt buộc',
                'max_participants.integer' => 'Số lượng tham gia phải là số nguyên',
                'max_participants.min' => 'Số lượng tham gia phải ít nhất 1 người',
                'start_date.required' => 'Ngày bắt đầu là bắt buộc',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ',
                'end_date.required' => 'Ngày kết thúc là bắt buộc',
                'end_date.date' => 'Ngày kết thúc không hợp lệ',
                'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
                'location.required' => 'Địa điểm là bắt buộc',
                'location.max' => 'Địa điểm không được vượt quá 255 ký tự',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
                'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
                'category_id.exists' => 'Danh mục không tồn tại',
                'status.in' => 'Trạng thái không hợp lệ'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tourData = $request->except(['image']);

            // Xử lý upload ảnh mới
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($tour->image && Storage::disk('public')->exists($tour->image)) {
                    Storage::disk('public')->delete($tour->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('tours', $imageName, 'public');
                $tourData['image'] = $imagePath;
            }

            $tour->update($tourData);
            $tour->load(['category', 'creator:user_id,username,fullname']);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật tour thành công',
                'data' => $tour
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật tour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa tour
     */
    public function destroy($id): JsonResponse
    {
        try {
            $tour = Tour::find($id);

            if (!$tour) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy tour'
                ], 404);
            }

            // Xóa ảnh nếu có
            if ($tour->image && Storage::disk('public')->exists($tour->image)) {
                Storage::disk('public')->delete($tour->image);
            }

            $tour->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa tour thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Thay đổi trạng thái tour
     */
    public function changeStatus(Request $request, $id): JsonResponse
    {
        try {
            $tour = Tour::find($id);

            if (!$tour) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy tour'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:active,inactive,completed,cancelled'
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

            $tour->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Thay đổi trạng thái tour thành công',
                'data' => $tour
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thay đổi trạng thái tour',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}