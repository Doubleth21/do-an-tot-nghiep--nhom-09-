# Admin - Quản lý tour - Backend

## Mô tả
Xây dựng hoàn chỉnh API Backend cho chức năng quản lý tour của Admin

## Chức năng đã hoàn thành
✅ TourController với đầy đủ CRUD operations:
- `index()` - Lấy danh sách tất cả tour
- `show($id)` - Xem chi tiết 1 tour
- `store()` - Tạo tour mới
- `update($id)` - Cập nhật thông tin tour
- `destroy($id)` - Xóa tour

✅ Tour Model:
- Table: `tour`
- Primary key: `tour_id`
- Fields: category_id, name, description, policy, supplier, image, status, price

✅ API Routes:
- GET `/api/tour` - Danh sách tour
- GET `/api/tour/{id}` - Chi tiết tour
- POST `/api/tour` - Tạo tour mới
- PUT `/api/tour/{id}` - Cập nhật tour
- DELETE `/api/tour/{id}` - Xóa tour

✅ Phân quyền: Admin và Tour Guide

## Files liên quan
- `server/app/Http/Controllers/Api/TourController.php`
- `server/app/Models/Tour.php`
- `server/routes/api.php`
