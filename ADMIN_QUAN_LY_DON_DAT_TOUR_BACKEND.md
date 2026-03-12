# Admin - Quản lý đơn đặt tour - Backend

## Mô tả
Xây dựng hoàn chỉnh API Backend cho chức năng quản lý đơn đặt tour của Admin

## Chức năng đã hoàn thành
✅ BookingController với đầy đủ chức năng:
- `index()` - Lấy danh sách tất cả booking
- `show($id)` - Xem chi tiết 1 booking
- `store()` - Tạo booking mới (đặt tour)
- `update($id)` - Cập nhật booking (status, payment_status, num_people)
- `destroy($id)` - Xóa booking
- `customerBookings($customer_id)` - Lấy tất cả booking của 1 customer
- `tourBookings($tour_id)` - Lấy tất cả booking của 1 tour

✅ Booking Model (đã sửa phù hợp database):
- Table: `booking`
- Primary key: `booking_id`
- Fields: customer_id, tour_id, schedule_id, booking_date, num_people, total_price, status, payment_status, note
- Relationships: customer, tour, schedule

✅ Customer Model (mới tạo):
- Table: `customer`
- Primary key: `customer_id`
- Relationship với Booking

✅ DepartureSchedule Model (mới tạo):
- Table: `departure_schedule`
- Primary key: `schedule_id`
- Relationship với Booking và Tour

✅ API Routes:
- GET `/api/booking` - Danh sách booking
- GET `/api/booking/{id}` - Chi tiết booking
- POST `/api/booking` - Tạo booking mới
- PUT `/api/booking/{id}` - Cập nhật booking
- DELETE `/api/booking/{id}` - Xóa booking
- GET `/api/customer/{customer_id}/bookings` - Booking của customer
- GET `/api/tour/{tour_id}/bookings` - Booking của tour

✅ File test API: `test-booking-api.html`

✅ Phân quyền: Admin và Tour Guide

## Files liên quan
- `server/app/Http/Controllers/Api/BookingController.php`
- `server/app/Models/Booking.php`
- `server/app/Models/Customer.php`
- `server/app/Models/DepartureSchedule.php`
- `test-booking-api.html`

## Thống kê
- Files thay đổi: 5 files
- Dòng code thêm: 396 dòng
- Models mới: 2 (Customer, DepartureSchedule)
