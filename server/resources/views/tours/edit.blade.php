<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tour - Tour Management</title>
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
                        <h2><i class="fas fa-edit text-warning me-2"></i>Sửa Tour: {{ $tour['tour_name'] }}</h2>
                        <a href="/tours" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>

                    <form id="editTourForm">
                        <input type="hidden" name="tour_id" value="{{ $tour['tour_id'] }}">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-map-marked-alt text-primary me-1"></i>Tên Tour *
                                </label>
                                <input type="text" class="form-control" name="tour_name" value="{{ $tour['tour_name'] }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-list text-info me-1"></i>Danh mục
                                </label>
                                <select class="form-select" name="category_id">
                                    <option value="">Chọn danh mục</option>
                                    <option value="1" {{ $tour['category'] == 'Du lịch biển' ? 'selected' : '' }}>Du lịch biển</option>
                                    <option value="2" {{ $tour['category'] == 'Du lịch núi' ? 'selected' : '' }}>Du lịch núi</option>
                                    <option value="3" {{ $tour['category'] == 'Du lịch văn hóa' ? 'selected' : '' }}>Du lịch văn hóa</option>
                                    <option value="4" {{ $tour['category'] == 'Du lịch ẩm thực' ? 'selected' : '' }}>Du lịch ẩm thực</option>
                                    <option value="5" {{ $tour['category'] == 'Du lịch mạo hiểm' ? 'selected' : '' }}>Du lịch mạo hiểm</option>
                                    <option value="6" {{ $tour['category'] == 'Du lịch sinh thái' ? 'selected' : '' }}>Du lịch sinh thái</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-align-left text-secondary me-1"></i>Mô tả
                            </label>
                            <textarea class="form-control" name="description" rows="3">{{ $tour['description'] }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-money-bill-wave text-success me-1"></i>Giá (VNĐ) *
                                </label>
                                <input type="number" class="form-control" name="price" value="{{ $tour['price_raw'] }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar text-warning me-1"></i>Thời gian (ngày) *
                                </label>
                                <input type="number" class="form-control" name="duration" value="{{ str_replace(' ngày', '', $tour['duration']) }}" min="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-users text-info me-1"></i>Số người tối đa *
                                </label>
                                <input type="number" class="form-control" name="max_participants" value="{{ $tour['max_participants'] }}" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>Địa điểm *
                            </label>
                            <input type="text" class="form-control" name="location" value="{{ $tour['location'] }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-image text-info me-1"></i>Hình ảnh mới
                            </label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-toggle-on text-success me-1"></i>Trạng thái
                            </label>
                            <select class="form-select" name="status">
                                <option value="active" {{ $tour['status'] == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ $tour['status'] == 'inactive' ? 'selected' : '' }}>Tạm ngưng</option>
                                <option value="completed" {{ $tour['status'] == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                <option value="cancelled" {{ $tour['status'] == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-secondary me-md-2" onclick="window.location.href='/tours'">
                                <i class="fas fa-times me-2"></i>Hủy
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Cập nhật Tour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('editTourForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const tourData = Object.fromEntries(formData);
            
            alert('Tour đã được cập nhật thành công!\n\nDữ liệu mới: ' + JSON.stringify(tourData, null, 2));
            window.location.href = '/tours';
        });
    </script>
</body>
</html>