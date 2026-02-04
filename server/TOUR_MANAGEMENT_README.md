# Tour Management System - Backend

## 📋 Tổng quan

Hệ thống quản lý tour du lịch được xây dựng trên Laravel với các tính năng đầy đủ cho việc quản lý tour và danh mục tour.

## 🚀 Tính năng chính

### ✅ Quản lý Tour
- CRUD operations (Tạo, Đọc, Cập nhật, Xóa)
- Upload và quản lý hình ảnh
- Phân trang, tìm kiếm, lọc theo nhiều tiêu chí
- Quản lý trạng thái tour (active, inactive, completed, cancelled)
- Validation đầy đủ với thông báo tiếng Việt

### ✅ Quản lý Danh mục
- CRUD operations cho danh mục tour
- Kiểm tra ràng buộc khi xóa
- Phân trang và tìm kiếm

### ✅ Dashboard & Thống kê
- Thống kê tổng quan về tour và danh mục
- Báo cáo doanh thu và hiệu suất

### ✅ Bảo mật & Phân quyền
- Authentication với Laravel Sanctum
- Role-based access control (admin, tour_guide, user)
- Middleware bảo vệ routes

## 📁 Cấu trúc Files

```
server/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   ├── TourController.php
│   │   │   ├── CategoryController.php
│   │   │   └── DashboardController.php
│   │   ├── Requests/
│   │   │   ├── StoreTourRequest.php
│   │   │   └── UpdateTourRequest.php
│   │   └── Resources/
│   │       ├── TourResource.php
│   │       └── CategoryResource.php
│   ├── Models/
│   │   ├── Tour.php
│   │   └── Category.php
│   ├── Services/
│   │   ├── TourService.php
│   │   └── CategoryService.php
│   ├── Traits/
│   │   └── ApiResponseTrait.php
│   ├── Helpers/
│   │   └── ImageHelper.php
│   └── Exceptions/
│       ├── TourException.php
│       └── CategoryException.php
├── database/
│   ├── migrations/
│   │   ├── 2026_01_26_000001_create_categories_table.php
│   │   └── 2026_01_26_000002_create_tours_table.php
│   ├── seeders/
│   │   ├── CategorySeeder.php
│   │   └── TourSeeder.php
│   └── factories/
│       ├── TourFactory.php
│       └── CategoryFactory.php
├── config/
│   └── tour.php
└── tests/
    └── Feature/
        └── TourApiTest.php
```

## 🛠️ Cài đặt và Chạy

### 1. Cài đặt dependencies
```bash
cd server
composer install
```

### 2. Cấu hình môi trường
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Cấu hình database trong .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tour_management
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Chạy migration và seeder
```bash
php artisan migrate
php artisan db:seed
```

### 5. Tạo symbolic link cho storage
```bash
php artisan storage:link
```

### 6. Chạy server
```bash
php artisan serve
```

## 📚 API Endpoints

### Authentication
- `POST /api/auth/register` - Đăng ký
- `POST /api/auth/login` - Đăng nhập
- `GET /api/auth/me` - Thông tin user hiện tại
- `POST /api/auth/logout` - Đăng xuất

### Public Routes
- `GET /api/tours` - Danh sách tour công khai
- `GET /api/tours/{id}` - Chi tiết tour
- `GET /api/categories` - Danh sách danh mục công khai
- `GET /api/categories/{id}` - Chi tiết danh mục

### Admin Routes (Cần authentication + role admin/tour_guide)
- `GET /api/admin/dashboard/statistics` - Thống kê dashboard

#### Tour Management
- `GET /api/admin/tours` - Danh sách tour (admin)
- `POST /api/admin/tours` - Tạo tour mới
- `GET /api/admin/tours/{id}` - Chi tiết tour (admin)
- `PUT /api/admin/tours/{id}` - Cập nhật tour
- `DELETE /api/admin/tours/{id}` - Xóa tour
- `PATCH /api/admin/tours/{id}/status` - Thay đổi trạng thái

#### Category Management
- `GET /api/admin/categories` - Danh sách danh mục (admin)
- `POST /api/admin/categories` - Tạo danh mục mới
- `GET /api/admin/categories/{id}` - Chi tiết danh mục (admin)
- `PUT /api/admin/categories/{id}` - Cập nhật danh mục
- `DELETE /api/admin/categories/{id}` - Xóa danh mục
- `PATCH /api/admin/categories/{id}/status` - Thay đổi trạng thái

## 🔧 Query Parameters

### Tours
- `status`: active, inactive, completed, cancelled
- `category_id`: ID danh mục
- `search`: Tìm kiếm theo tên, địa điểm
- `price_min`, `price_max`: Lọc theo giá
- `start_date`, `end_date`: Lọc theo ngày
- `sort_by`: Trường sắp xếp
- `sort_order`: asc, desc
- `per_page`: Số item per page

### Categories
- `status`: active, inactive
- `search`: Tìm kiếm theo tên
- `all`: true để lấy tất cả không phân trang

## 🧪 Testing

Chạy tests:
```bash
php artisan test
php artisan test --filter TourApiTest
```

## 📝 Validation Rules

### Tour
- `tour_name`: required, max:255
- `price`: required, numeric, min:0
- `duration`: required, integer, min:1
- `max_participants`: required, integer, min:1
- `start_date`: required, date, after:today
- `end_date`: required, date, after:start_date
- `location`: required, max:255
- `image`: nullable, image, max:2048KB

### Category
- `category_name`: required, max:255, unique
- `description`: nullable
- `status`: in:active,inactive

## 🔐 Roles & Permissions

- **admin**: Toàn quyền quản lý
- **tour_guide**: Quản lý tour (giống admin)
- **user**: Chỉ xem thông tin công khai

## 📊 Database Schema

### Tours Table
- `tour_id` (PK)
- `tour_name`
- `description`
- `price`
- `duration`
- `max_participants`
- `start_date`
- `end_date`
- `location`
- `image`
- `status`
- `category_id` (FK)
- `created_by` (FK)
- `timestamps`

### Categories Table
- `category_id` (PK)
- `category_name`
- `description`
- `status`
- `timestamps`

## 🎯 Tính năng nâng cao

- **API Resources**: Format dữ liệu response nhất quán
- **Service Layer**: Tách logic business khỏi controller
- **Exception Handling**: Xử lý lỗi tùy chỉnh
- **Image Helper**: Utilities cho xử lý hình ảnh
- **API Response Trait**: Chuẩn hóa response format
- **Factory & Seeder**: Tạo dữ liệu test và mẫu
- **Configuration**: File config tùy chỉnh cho tour system

## 📖 Documentation

Chi tiết API documentation có trong file `API_DOCUMENTATION.md`

## 🚀 Production Ready

Hệ thống đã sẵn sàng cho production với:
- ✅ Validation đầy đủ
- ✅ Error handling
- ✅ Security middleware
- ✅ Database optimization (indexes)
- ✅ File upload handling
- ✅ API documentation
- ✅ Testing coverage
- ✅ Clean code structure