<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * Hiển thị danh sách tours trên giao diện web
     */
    public function tours()
    {
        $tours = $this->getSampleTours();
        return view('tours.index', compact('tours'));
    }

    /**
     * Hiển thị danh sách categories trên giao diện web
     */
    public function categories()
    {
        // Dữ liệu mẫu categories
        $categories = [
            [
                'category_id' => 1,
                'category_name' => 'Du lịch biển',
                'description' => 'Các tour du lịch biển, nghỉ dưỡng tại các bãi biển đẹp, thưởng thức hải sản và tham gia các hoạt động thể thao nước.',
                'status' => 'active',
                'tours_count' => 8
            ],
            [
                'category_id' => 2,
                'category_name' => 'Du lịch núi',
                'description' => 'Các tour leo núi, trekking, khám phá thiên nhiên hoang dã và trải nghiệm cuộc sống vùng cao.',
                'status' => 'active',
                'tours_count' => 5
            ],
            [
                'category_id' => 3,
                'category_name' => 'Du lịch văn hóa',
                'description' => 'Khám phá văn hóa, lịch sử, di tích và truyền thống của các vùng miền khác nhau.',
                'status' => 'active',
                'tours_count' => 12
            ],
            [
                'category_id' => 4,
                'category_name' => 'Du lịch ẩm thực',
                'description' => 'Trải nghiệm ẩm thực địa phương, học nấu ăn và khám phá văn hóa ẩm thực đặc sắc.',
                'status' => 'active',
                'tours_count' => 6
            ],
            [
                'category_id' => 5,
                'category_name' => 'Du lịch mạo hiểm',
                'description' => 'Các hoạt động mạo hiểm, thể thao cực hạn như zipline, bungee jumping, rafting.',
                'status' => 'active',
                'tours_count' => 4
            ],
            [
                'category_id' => 6,
                'category_name' => 'Du lịch sinh thái',
                'description' => 'Khám phá thiên nhiên, bảo vệ môi trường và trải nghiệm cuộc sống gần gũi với thiên nhiên.',
                'status' => 'active',
                'tours_count' => 7
            ]
        ];

        return view('categories.index', compact('categories'));
    }

    /**
     * Hiển thị chi tiết tour
     */
    public function showTour($id)
    {
        // Tìm tour theo ID (giả lập)
        $tours = $this->getSampleTours();
        $tour = collect($tours)->firstWhere('tour_id', $id);
        
        if (!$tour) {
            abort(404, 'Tour không tồn tại');
        }
        
        return view('tours.show', compact('tour'));
    }

    /**
     * Hiển thị form tạo tour mới
     */
    public function createTour()
    {
        return view('tours.create');
    }

    /**
     * Hiển thị form sửa tour
     */
    public function editTour($id)
    {
        // Tìm tour theo ID (giả lập)
        $tours = $this->getSampleTours();
        $tour = collect($tours)->firstWhere('tour_id', $id);
        
        if (!$tour) {
            abort(404, 'Tour không tồn tại');
        }
        
        return view('tours.edit', compact('tour'));
    }

    /**
     * Lưu tour mới
     */
    public function storeTour(Request $request)
    {
        // Giả lập lưu tour
        return redirect('/tours')->with('success', 'Tour đã được thêm thành công!');
    }

    /**
     * Cập nhật tour
     */
    public function updateTour(Request $request, $id)
    {
        // Giả lập cập nhật tour
        return redirect('/tours')->with('success', 'Tour đã được cập nhật thành công!');
    }

    /**
     * Xóa tour
     */
    public function deleteTour($id)
    {
        // Giả lập xóa tour
        return redirect('/tours')->with('success', 'Tour đã được xóa thành công!');
    }

    /**
     * Lấy dữ liệu mẫu tours
     */
    private function getSampleTours()
    {
        return [
            [
                'tour_id' => 1,
                'tour_name' => 'Tour Hạ Long Bay 2N1Đ',
                'description' => 'Khám phá vịnh Hạ Long với những hang động tuyệt đẹp, thưởng thức hải sản tươi ngon và ngắm hoàng hôn trên vịnh.',
                'price' => '1,500,000 VNĐ',
                'price_raw' => 1500000,
                'duration' => '2 ngày',
                'max_participants' => 20,
                'location' => 'Vịnh Hạ Long, Quảng Ninh',
                'status' => 'active',
                'category' => 'Du lịch biển'
            ],
            [
                'tour_id' => 2,
                'tour_name' => 'Trekking Sapa 3N2Đ',
                'description' => 'Leo núi Fansipan, khám phá bản làng dân tộc, ngắm ruộng bậc thang và trải nghiệm văn hóa địa phương.',
                'price' => '2,200,000 VNĐ',
                'price_raw' => 2200000,
                'duration' => '3 ngày',
                'max_participants' => 15,
                'location' => 'Sapa, Lào Cai',
                'status' => 'active',
                'category' => 'Du lịch núi'
            ],
            [
                'tour_id' => 3,
                'tour_name' => 'Khám phá Hội An - Huế 4N3Đ',
                'description' => 'Tham quan phố cổ Hội An, Đại Nội Huế, thưởng thức ẩm thực cung đình và khám phá di sản văn hóa.',
                'price' => '3,500,000 VNĐ',
                'price_raw' => 3500000,
                'duration' => '4 ngày',
                'max_participants' => 25,
                'location' => 'Hội An - Huế',
                'status' => 'active',
                'category' => 'Du lịch văn hóa'
            ],
            [
                'tour_id' => 4,
                'tour_name' => 'Food Tour Sài Gòn 1 ngày',
                'description' => 'Khám phá ẩm thực đường phố Sài Gòn, từ phở, bánh mì đến chè, cà phê và các món đặc sản.',
                'price' => '500,000 VNĐ',
                'price_raw' => 500000,
                'duration' => '1 ngày',
                'max_participants' => 12,
                'location' => 'TP. Hồ Chí Minh',
                'status' => 'active',
                'category' => 'Du lịch ẩm thực'
            ],
            [
                'tour_id' => 5,
                'tour_name' => 'Phong Nha - Kẻ Bàng 3N2Đ',
                'description' => 'Khám phá hang động Phong Nha, Thiên Đường, trải nghiệm zipline và các hoạt động mạo hiểm.',
                'price' => '2,800,000 VNĐ',
                'price_raw' => 2800000,
                'duration' => '3 ngày',
                'max_participants' => 18,
                'location' => 'Phong Nha - Kẻ Bàng, Quảng Bình',
                'status' => 'active',
                'category' => 'Du lịch mạo hiểm'
            ],
            [
                'tour_id' => 6,
                'tour_name' => 'Cần Thơ - Miệt vườn 2N1Đ',
                'description' => 'Trải nghiệm cuộc sống miệt vườn, chợ nổi Cái Răng, thưởng thức trái cây nhiệt đới tươi ngon.',
                'price' => '1,200,000 VNĐ',
                'price_raw' => 1200000,
                'duration' => '2 ngày',
                'max_participants' => 20,
                'location' => 'Cần Thơ, Đồng bằng sông Cửu Long',
                'status' => 'active',
                'category' => 'Du lịch sinh thái'
            ]
        ];
    }

    /**
     * Trang chủ với tổng quan
     */
    public function home()
    {
        return view('welcome');
    }
}