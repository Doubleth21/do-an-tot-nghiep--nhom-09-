<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tour['tour_name'] }} - Tour Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .tour-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
        }
        .tour-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .info-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .price-highlight {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .status-badge {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }
        .feature-icon {
            color: #667eea;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="tour-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb text-white-50">
                            <li class="breadcrumb-item"><a href="/" class="text-white-50">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="/tours" class="text-white-50">Tours</a></li>
                            <li class="breadcrumb-item active text-white">{{ $tour['tour_name'] }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 mb-2">{{ $tour['tour_name'] }}</h1>
                    <p class="lead mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $tour['location'] }}
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="/tours" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                        <a href="/tours/{{ $tour['tour_id'] }}/edit" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Tour Image -->
                <div class="info-card">
                    <img src="https://via.placeholder.com/800x300/667eea/ffffff?text={{ urlencode($tour['tour_name']) }}" 
                         alt="{{ $tour['tour_name'] }}" class="tour-image">
                </div>

                <!-- Description -->
                <div class="info-card">
                    <h3><i class="fas fa-info-circle feature-icon"></i>Mô tả Tour</h3>
                    <p class="lead">{{ $tour['description'] }}</p>
                </div>

                <!-- Tour Details -->
                <div class="info-card">
                    <h3><i class="fas fa-list-ul feature-icon"></i>Thông tin chi tiết</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt feature-icon fa-lg"></i>
                                <div>
                                    <strong>Thời gian:</strong><br>
                                    <span class="text-muted">{{ $tour['duration'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users feature-icon fa-lg"></i>
                                <div>
                                    <strong>Số người tối đa:</strong><br>
                                    <span class="text-muted">{{ $tour['max_participants'] }} người</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt feature-icon fa-lg"></i>
                                <div>
                                    <strong>Địa điểm:</strong><br>
                                    <span class="text-muted">{{ $tour['location'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tag feature-icon fa-lg"></i>
                                <div>
                                    <strong>Danh mục:</strong><br>
                                    <span class="badge bg-primary">{{ $tour['category'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tour Features -->
                <div class="info-card">
                    <h3><i class="fas fa-star feature-icon"></i>Điểm nổi bật</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Hướng dẫn viên chuyên nghiệp
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Bao gồm bữa ăn
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Xe đưa đón tận nơi
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Bảo hiểm du lịch
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Khách sạn tiêu chuẩn
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Hỗ trợ 24/7
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Price Card -->
                <div class="info-card">
                    <div class="price-highlight">
                        <i class="fas fa-money-bill-wave me-2"></i>
                        {{ $tour['price'] }}
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Giá cho mỗi người</small>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="info-card">
                    <h5><i class="fas fa-info-circle feature-icon"></i>Trạng thái Tour</h5>
                    <div class="text-center">
                        @if($tour['status'] == 'active')
                            <span class="badge bg-success status-badge">
                                <i class="fas fa-check-circle me-1"></i>Đang hoạt động
                            </span>
                            <p class="text-success mt-2 mb-0">
                                <i class="fas fa-thumbs-up me-1"></i>Sẵn sàng đặt tour
                            </p>
                        @elseif($tour['status'] == 'inactive')
                            <span class="badge bg-warning status-badge">
                                <i class="fas fa-pause-circle me-1"></i>Tạm ngưng
                            </span>
                            <p class="text-warning mt-2 mb-0">
                                <i class="fas fa-exclamation-triangle me-1"></i>Hiện tại không khả dụng
                            </p>
                        @elseif($tour['status'] == 'completed')
                            <span class="badge bg-info status-badge">
                                <i class="fas fa-check-double me-1"></i>Đã hoàn thành
                            </span>
                            <p class="text-info mt-2 mb-0">
                                <i class="fas fa-flag-checkered me-1"></i>Tour đã kết thúc
                            </p>
                        @else
                            <span class="badge bg-danger status-badge">
                                <i class="fas fa-times-circle me-1"></i>Đã hủy
                            </span>
                            <p class="text-danger mt-2 mb-0">
                                <i class="fas fa-ban me-1"></i>Tour đã bị hủy
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="info-card">
                    <h5><i class="fas fa-cogs feature-icon"></i>Thao tác nhanh</h5>
                    <div class="d-grid gap-2">
                        <a href="/tours/{{ $tour['tour_id'] }}/edit" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa Tour
                        </a>
                        <button class="btn btn-danger" onclick="deleteTour({{ $tour['tour_id'] }}, '{{ $tour['tour_name'] }}')">
                            <i class="fas fa-trash me-2"></i>Xóa Tour
                        </button>
                        <a href="/tours" class="btn btn-secondary">
                            <i class="fas fa-list me-2"></i>Danh sách Tours
                        </a>
                    </div>
                </div>

                <!-- Tour Stats -->
                <div class="info-card">
                    <h5><i class="fas fa-chart-bar feature-icon"></i>Thống kê</h5>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $tour['tour_id'] }}</h4>
                                <small class="text-muted">ID Tour</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $tour['max_participants'] }}</h4>
                            <small class="text-muted">Chỗ trống</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p>&copy; 2026 Tour Management System. Chi tiết tour: {{ $tour['tour_name'] }}</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteTour(tourId, tourName) {
            if (confirm(`Bạn có chắc chắn muốn xóa tour "${tourName}"?\n\nHành động này không thể hoàn tác!`)) {
                alert(`Tour "${tourName}" đã được xóa thành công!`);
                window.location.href = '/tours';
            }
        }
    </script>
</body>
</html>