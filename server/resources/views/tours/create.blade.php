<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tour Mới - Tour Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="form-container p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-plus-circle text-primary me-2"></i>Thêm Tour Mới</h2>
                        <a href="/tours" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>

                    <form id="tourForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-map-marked-alt text-primary me-1"></i>Tên Tour *
                                </label>
                                <input type="text" class="form-control" name="tour_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-list text-info me-1"></i>Danh mục
                                </label>
                                <select class="form-select" name="category_id">
                                    <option value="">Chọn danh mục</option>
                                    <option value="1">Du lịch biển</option>
                                    <option value="2">Du lịch núi</option>
                                    <option value="3">Du lịch văn hóa</option>
                                    <option value="4">Du lịch ẩm thực</option>
                                    <option value="5">Du lịch mạo hiểm</option>
                                    <option value="6">Du lịch sinh thái</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-align-left text-secondary me-1"></i>Mô tả
                            </label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-money-bill-wave text-success me-1"></i>Giá (VNĐ) *
                                </label>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar text-warning me-1"></i>Thời gian (ngày) *
                                </label>
                                <input type="number" class="form-control" name="duration" min="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-users text-info me-1"></i>Số người tối đa *
                                </label>
                                <input type="number" class="form-control" name="max_participants" min="1" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt text-primary me-1"></i>Ngày bắt đầu *
                                </label>
                                <input type="datetime-local" class="form-control" name="start_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check text-danger me-1"></i>Ngày kết thúc *
                                </label>
                                <input type="datetime-local" class="form-control" name="end_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>Địa điểm *
                            </label>
                            <input type="text" class="form-control" name="location" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-image text-info me-1"></i>Hình ảnh
                            </label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <small class="text-muted">Chấp nhận: JPG, PNG, GIF. Tối đa 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-toggle-on text-success me-1"></i>Trạng thái
                            </label>
                            <select class="form-select" name="status">
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Tạm ngưng</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-secondary me-md-2" onclick="window.location.href='/tours'">
                                <i class="fas fa-times me-2"></i>Hủy
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu Tour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('tourForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Giả lập gửi dữ liệu
            const formData = new FormData(this);
            const tourData = Object.fromEntries(formData);
            
            // Hiển thị thông báo thành công
            alert('Tour đã được thêm thành công!\n\nDữ liệu: ' + JSON.stringify(tourData, null, 2));
            
            // Chuyển về trang danh sách
            window.location.href = '/tours';
        });
    </script>
</body>
</html>