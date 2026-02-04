<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Tours - Tour Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .tour-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .tour-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.2em;
        }
        .status-badge {
            font-size: 0.8em;
        }
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-map-marked-alt me-3"></i>Danh sách Tours Du lịch</h1>
                    <p class="mb-0">Khám phá những tour du lịch tuyệt vời nhất</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="/tours/create" class="btn btn-success me-2">
                        <i class="fas fa-plus me-2"></i>Thêm Tour
                    </a>
                    <a href="/categories" class="btn btn-light">
                        <i class="fas fa-list me-2"></i>Xem Danh mục
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h3 class="text-primary">{{ count($tours) }}</h3>
                                    <p class="mb-0">Tổng số Tours</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h3 class="text-success">{{ collect($tours)->where('status', 'active')->count() }}</h3>
                                    <p class="mb-0">Tours Đang hoạt động</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h3 class="text-info">{{ collect($tours)->unique('category')->count() }}</h3>
                                    <p class="mb-0">Danh mục</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h3 class="text-warning">{{ number_format(collect($tours)->avg('price_raw'), 0, ',', '.') }} VNĐ</h3>
                                    <p class="mb-0">Giá trung bình</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($tours as $tour)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card tour-card h-100">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $tour['tour_name'] }}</h5>
                            <span class="badge bg-light text-dark status-badge">
                                @if($tour['status'] == 'active')
                                    <i class="fas fa-check-circle text-success"></i> Hoạt động
                                @else
                                    <i class="fas fa-pause-circle text-warning"></i> Tạm dừng
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $tour['description'] }}</p>
                        
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt text-danger"></i> Địa điểm
                                    </small>
                                    <p class="mb-1">{{ $tour['location'] }}</p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar text-info"></i> Thời gian
                                    </small>
                                    <p class="mb-1">{{ $tour['duration'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-users text-success"></i> Số người
                                    </small>
                                    <p class="mb-1">{{ $tour['max_participants'] }} người</p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-tag text-warning"></i> Danh mục
                                    </small>
                                    <p class="mb-1">{{ $tour['category'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="price text-center">
                            <i class="fas fa-money-bill-wave"></i> {{ $tour['price'] }}
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/tours/{{ $tour['tour_id'] }}" class="btn btn-outline-primary btn-sm me-md-2">
                                <i class="fas fa-eye me-1"></i>Xem
                            </a>
                            <a href="/tours/{{ $tour['tour_id'] }}/edit" class="btn btn-warning btn-sm me-md-2">
                                <i class="fas fa-edit me-1"></i>Sửa
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="deleteTour({{ $tour['tour_id'] }}, '{{ $tour['tour_name'] }}')">
                                <i class="fas fa-trash me-1"></i>Xóa
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(empty($tours))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h4>Chưa có tour nào</h4>
                        <p class="text-muted">Hiện tại chưa có tour nào trong hệ thống.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p>&copy; 2026 Tour Management System. Được phát triển bởi AI Assistant.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteTour(tourId, tourName) {
            if (confirm(`Bạn có chắc chắn muốn xóa tour "${tourName}"?\n\nHành động này không thể hoàn tác!`)) {
                // Giả lập xóa tour
                alert(`Tour "${tourName}" đã được xóa thành công!`);
                
                // Reload trang để cập nhật danh sách
                window.location.reload();
            }
        }
    </script>
</body>
</html>