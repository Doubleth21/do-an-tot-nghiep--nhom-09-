# 📋 HƯỚNG DẪN CALL API ĐẶT TOUR BẰNG POSTMAN

## 1. TỔNG QUAN
Hệ thống đặt tour có các endpoint chính sau:

| Method | Endpoint | Mô tả |
|--------|----------|-------|
| POST | `/api/auth/register` | Đăng ký tài khoản |
| POST | `/api/auth/login` | Đăng nhập |
| POST | `/api/booking` | Đặt tour mới |
| GET | `/api/booking` | Lấy danh sách booking của user |
| GET | `/api/booking/{id}` | Lấy chi tiết booking |
| PUT | `/api/booking/{id}` | Cập nhật booking |
| DELETE | `/api/booking/{id}` | Hủy booking |
| GET | `/api/tour/{tour_id}/bookings` | Lấy booking của 1 tour (Admin/Guide) |
| GET | `/api/user/{user_id}/bookings` | Lấy booking của 1 user (Admin) |

---

## 2. SETUP POSTMAN

### Step 1: Tạo Collection
- Mở Postman
- Click "+" để tạo request mới
- Hoặc tạo Collection: File → New → Collection

### Step 2: Tạo Environment Variable
- Click "Environments" → "Create New"
- Đặt tên: `BookingAPI`
- Thêm biến:
  ```
  {
    "base_url": "http://localhost:8000/api",
    "token": ""
  }
  ```
- Save

### Step 3: Chọn Environment
- Click dropdown "No Environment" → chọn `BookingAPI`

---

## 3. STEP BY STEP TESTING

### STEP 1: Đăng Ký Tài Khoản

**Request:**
```
Method: POST
URL: {{base_url}}/auth/register
Headers:
  - Content-Type: application/json

Body (raw JSON):
{
  "username": "user1",
  "password": "password123",
  "password_confirmation": "password123",
  "fullname": "Nguyen Van A",
  "email": "user1@example.com",
  "phone": "0123456789"
}
```

**Response (Success):**
```json
{
  "message": "User registered successfully",
  "user": {
    "user_id": 1,
    "username": "user1",
    "fullname": "Nguyen Van A",
    "email": "user1@example.com",
    "phone": "0123456789",
    "role": "user",
    "status": "active",
    "created_at": "2026-01-31T10:00:00.000000Z"
  },
  "token": "1|abc123...xyz789"
}
```

---

### STEP 2: Đăng Nhập

**Request:**
```
Method: POST
URL: {{base_url}}/auth/login
Headers:
  - Content-Type: application/json

Body (raw JSON):
{
  "username": "user1",
  "password": "password123"
}
```

**Response (Success):**
```json
{
  "message": "Login successful",
  "token": "1|abc123...xyz789",
  "user": {
    "user_id": 1,
    "username": "user1",
    "fullname": "Nguyen Van A",
    "email": "user1@example.com",
    "role": "user",
    "status": "active"
  }
}
```

**💡 LƯU Ý:**
- Copy token từ response
- Vào Environments → Edit `BookingAPI`
- Set `token` = token vừa copy
- Save

---

### STEP 3: Lấy Danh Sách Tour

**Request:**
```
Method: GET
URL: http://localhost:8000/api/tour
```

**Response Example:**
```json
[
  {
    "tour_id": 1,
    "category_id": 1,
    "name": "Tour Hà Nội 3 Ngày",
    "description": "Khám phá Hà Nội cổ kính...",
    "price": "1500000",
    "status": "active",
    "image": "tour1.jpg"
  },
  {
    "tour_id": 2,
    "category_id": 2,
    "name": "Tour HCM 4 Ngày",
    "description": "Khám phá Sài Gòn hiện đại...",
    "price": "2000000",
    "status": "active",
    "image": "tour2.jpg"
  }
]
```

---

### STEP 4: Đặt Tour (Booking)

**Request:**
```
Method: POST
URL: {{base_url}}/booking
Headers:
  - Content-Type: application/json
  - Authorization: Bearer {{token}}

Body (raw JSON):
{
  "tour_id": 1,
  "quantity": 2,
  "notes": "Đặt tour cho gia đình, mong được hỗ trợ tối đa",
  "travel_date": "2026-03-15"
}
```

**Response (Success):**
```json
{
  "message": "Booking created successfully",
  "booking": {
    "booking_id": 1,
    "user_id": 1,
    "tour_id": 1,
    "quantity": 2,
    "total_price": "3000000",
    "status": "pending",
    "notes": "Đặt tour cho gia đình, mong được hỗ trợ tối đa",
    "booking_date": "2026-01-31T10:15:00.000000Z",
    "travel_date": "2026-03-15",
    "user": {
      "user_id": 1,
      "username": "user1",
      "fullname": "Nguyen Van A"
    },
    "tour": {
      "tour_id": 1,
      "name": "Tour Hà Nội 3 Ngày",
      "price": "1500000"
    },
    "created_at": "2026-01-31T10:15:00.000000Z",
    "updated_at": "2026-01-31T10:15:00.000000Z"
  }
}
```

---

### STEP 5: Lấy Danh Sách Booking Của User

**Request:**
```
Method: GET
URL: {{base_url}}/booking
Headers:
  - Authorization: Bearer {{token}}
```

**Response (Success):**
```json
[
  {
    "booking_id": 1,
    "user_id": 1,
    "tour_id": 1,
    "quantity": 2,
    "total_price": "3000000",
    "status": "pending",
    "notes": "Đặt tour cho gia đình",
    "booking_date": "2026-01-31T10:15:00.000000Z",
    "travel_date": "2026-03-15",
    "user": { ... },
    "tour": { ... }
  }
]
```

---

### STEP 6: Xem Chi Tiết Booking

**Request:**
```
Method: GET
URL: {{base_url}}/booking/1
Headers:
  - Authorization: Bearer {{token}}
```

**Response (Success):**
```json
{
  "booking_id": 1,
  "user_id": 1,
  "tour_id": 1,
  "quantity": 2,
  "total_price": "3000000",
  "status": "pending",
  "notes": "Đặt tour cho gia đình",
  "booking_date": "2026-01-31T10:15:00.000000Z",
  "travel_date": "2026-03-15",
  "user": { ... },
  "tour": { ... },
  "created_at": "2026-01-31T10:15:00.000000Z",
  "updated_at": "2026-01-31T10:15:00.000000Z"
}
```

---

### STEP 7: Cập Nhật Booking

**Request:**
```
Method: PUT
URL: {{base_url}}/booking/1
Headers:
  - Content-Type: application/json
  - Authorization: Bearer {{token}}

Body (raw JSON):
{
  "quantity": 3,
  "status": "confirmed",
  "notes": "Cập nhật thêm 1 khách"
}
```

**Response (Success):**
```json
{
  "message": "Booking updated successfully",
  "booking": {
    "booking_id": 1,
    "user_id": 1,
    "tour_id": 1,
    "quantity": 3,
    "total_price": "4500000",
    "status": "confirmed",
    "notes": "Cập nhật thêm 1 khách",
    "booking_date": "2026-01-31T10:15:00.000000Z",
    "travel_date": "2026-03-15",
    "user": { ... },
    "tour": { ... },
    "created_at": "2026-01-31T10:15:00.000000Z",
    "updated_at": "2026-01-31T10:20:00.000000Z"
  }
}
```

---

### STEP 8: Xóa Booking

**Request:**
```
Method: DELETE
URL: {{base_url}}/booking/1
Headers:
  - Authorization: Bearer {{token}}
```

**Response (Success):**
```json
{
  "message": "Booking deleted successfully"
}
```

**Response (Error - không thể xóa):**
```json
{
  "message": "Cannot delete booking with status confirmed"
}
```

---

## 4. ERROR HANDLING

### 401 - Unauthorized
```json
{
  "message": "Unauthenticated."
}
```
**Cách fix:** Kiểm tra token trong header Authorization

### 403 - Forbidden
```json
{
  "message": "Unauthorized"
}
```
**Cách fix:** Chỉ có admin hoặc chủ booking mới xem/sửa được

### 404 - Not Found
```json
{
  "message": "Booking not found"
}
```
**Cách fix:** Kiểm tra booking_id có tồn tại không

### 422 - Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "tour_id": [
      "The tour_id field is required."
    ],
    "quantity": [
      "The quantity must be at least 1."
    ]
  }
}
```
**Cách fix:** Kiểm tra dữ liệu gửi đi

---

## 5. CÁC FIELD VALIDATION

### Khi Đặt Tour
| Field | Type | Required | Rules |
|-------|------|----------|-------|
| tour_id | integer | ✅ | Phải tồn tại trong bảng tour |
| quantity | integer | ✅ | Min: 1, Max: 100 |
| notes | string | ❌ | Max: 500 characters |
| travel_date | date | ❌ | Phải >= hôm nay |

### Khi Cập Nhật
| Field | Type | Required | Rules |
|-------|------|----------|-------|
| quantity | integer | ❌ | Min: 1, Max: 100 |
| status | enum | ❌ | pending, confirmed, cancelled, completed |
| notes | string | ❌ | Max: 500 characters |
| travel_date | date | ❌ | Phải >= hôm nay |

---

## 6. POSTMAN COLLECTION SAMPLE

```json
{
  "info": {
    "name": "Booking Tour API",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "item": [
    {
      "name": "Register",
      "request": {
        "method": "POST",
        "header": [],
        "body": {
          "mode": "raw",
          "raw": "{\n  \"username\": \"user1\",\n  \"password\": \"password123\",\n  \"password_confirmation\": \"password123\",\n  \"fullname\": \"Nguyen Van A\",\n  \"email\": \"user1@example.com\",\n  \"phone\": \"0123456789\"\n}"
        },
        "url": {
          "raw": "{{base_url}}/auth/register",
          "host": ["{{base_url}}"],
          "path": ["auth", "register"]
        }
      }
    },
    {
      "name": "Login",
      "request": {
        "method": "POST",
        "header": [],
        "body": {
          "mode": "raw",
          "raw": "{\n  \"username\": \"user1\",\n  \"password\": \"password123\"\n}"
        },
        "url": {
          "raw": "{{base_url}}/auth/login",
          "host": ["{{base_url}}"],
          "path": ["auth", "login"]
        }
      }
    },
    {
      "name": "Create Booking",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Authorization",
            "value": "Bearer {{token}}"
          }
        ],
        "body": {
          "mode": "raw",
          "raw": "{\n  \"tour_id\": 1,\n  \"quantity\": 2,\n  \"notes\": \"Đặt tour cho gia đình\",\n  \"travel_date\": \"2026-03-15\"\n}"
        },
        "url": {
          "raw": "{{base_url}}/booking",
          "host": ["{{base_url}}"],
          "path": ["booking"]
        }
      }
    }
  ]
}
```

---

## 7. QUICK TEST CHECKLIST

- [ ] Đăng ký tài khoản thành công
- [ ] Đăng nhập thành công
- [ ] Copy token vào environment variable
- [ ] Lấy danh sách tour
- [ ] Đặt tour mới (status = pending)
- [ ] Lấy danh sách booking của user
- [ ] Xem chi tiết booking
- [ ] Cập nhật booking (thay đổi quantity, status)
- [ ] Xóa booking (chỉ khi status = pending)
- [ ] Kiểm tra error 403 (cố xem booking của user khác)
- [ ] Kiểm tra error 422 (validation)

---

## 8. TROUBLESHOOTING

### Lỗi: "Unauthenticated"
- ✅ Kiểm tra token có đúng không
- ✅ Kiểm tra header: `Authorization: Bearer <token>`
- ✅ Token có hết hạn không?

### Lỗi: "Unauthorized"
- ✅ User này có quyền xem/sửa booking này không?
- ✅ Chỉ admin hoặc chủ booking mới được

### Lỗi: "Booking not found"
- ✅ Booking ID có tồn tại không?
- ✅ Kiểm tra URL path

### Lỗi: Database Connection
- ✅ MySQL server có chạy không?
- ✅ Database `doan_totnghiep` tồn tại không?
- ✅ .env file có cấu hình đúng không?

---

## 9. TIPS

1. **Lưu thời gian**: Sau khi login, copy token vào environment variable
2. **Test Hierarchy**: Đăng ký → Đăng nhập → Tạo booking → Cập nhật → Xóa
3. **Sử dụng Pre-request Script**: Tự động set token sau login
4. **Sử dụng Tests**: Kiểm tra response trước khi xóa
5. **Collection Variables**: Lưu booking_id để dùng lại

---

**Chúc bạn thành công với việc test API! 🚀**
