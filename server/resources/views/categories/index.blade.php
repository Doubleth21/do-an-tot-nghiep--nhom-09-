<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Danh mục - Tour Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .category-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-list me-3"></i>Danh sách Danh mục Tour</h1>
                    <p class="mb-0">Các loại hình du lịch đa dạng</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="/tours" class="btn btn-light">
                        <i class="fas fa-map-marked-alt me-2"></i>Xem Tours
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
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h3 class="text-primary">{{ count($categories) }}</h3>
                                    <p class="mb-0">Tổng số Danh mục</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h3 class="text-success">{{ collect($categories)->where('status', 'active')->count() }}</h3>
                                    <p class="mb-0">Danh mục Hoạt động</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h3 class="text-info">{{ collect($categories)->sum('tours_count') }}</h3>
                                    <p class="mb-0">Tổng số Tours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card category-card h-100">
                    <div class="card-body text-center">
                        <div class="category-icon">
                            @if(str_contains($category['category_name'], 'biển'))
                                <i class="fas fa-water text-info"></i>
                            @elseif(str_contains($category['category_name'], 'núi'))
                                <i class="fas fa-mountain text-success"></i>
                            @elseif(str_contains($category['category_name'], 'văn hóa'))
                                <i class="fas fa-landmark text-warning"></i>
                            @elseif(str_contains($category['category_name'], 'ẩm thực'))
                                <i class="fas fa-utensils text-danger"></i>
                            @elseif(str_contains($category['category_name'], 'mạo hiểm'))
                                <i class="fas fa-hiking text-dark"></i>
                            @elseif(str_contains($category['category_name'], 'sinh thái'))
                                <i class="fas fa-leaf text-success"></i>
                            @else
                                <i class="fas fa-map text-primary"></i>
                            @endif
                        </div>
                        
                        <h4 class="card-title">{{ $category['category_name'] }}</h4>
                        <p class="card-text text-muted">{{ $category['description'] }}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-primary fs-6">
                                <i class="fas fa-map-marked-alt me-1"></i>
                                {{ $category['tours_count'] }} Tours
                            </span>
                            
                            @if($category['status'] == 'active')
                                <span class="badge bg-success fs-6 ms-2">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Hoạt động
                                </span>
                            @else
                                <span class="badge bg-warning fs-6 ms-2">
                                    <i class="fas fa-pause-circle me-1"></i>
                                    Tạm dừng
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>Xem Tours trong danh mục
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(empty($categories))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h4>Chưa có danh mục nào</h4>
                        <p class="text-muted">Hiện tại chưa có danh mục nào trong hệ thống.</p>
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
</body>
</html>