import React from "react";
import { Link } from "react-router-dom";

const Dashboard = () => {
  return (
    <div className="max-w-6xl mx-auto pb-20 p-4 animate-in fade-in duration-500">
      <div className="flex items-center gap-4 mb-8">
        <div>
          <h1 className="text-2xl font-extrabold text-slate-800 tracking-tight">Bảng điều khiển - Hướng dẫn viên</h1>
          <p className="text-sm text-slate-500 font-medium">Tổng quan nhanh về chuyến đi và đặt chỗ của bạn</p>
        </div>
      </div>

      <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Link to="/guide/bookings" className="block no-underline">
            <div className="p-6 rounded-[1.5rem] bg-slate-50 hover:bg-white transition-colors border border-slate-100">
              <h3 className="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Đặt chỗ hôm nay</h3>
              <p className="text-3xl font-black text-blue-600">12</p>
              <p className="text-xs text-slate-400 mt-2">Đang chờ xác nhận</p>
            </div>
          </Link>

          <Link to="/guide/tours" className="block no-underline">
            <div className="p-6 rounded-[1.5rem] bg-slate-50 hover:bg-white transition-colors border border-slate-100">
              <h3 className="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Tour sắp tới</h3>
              <p className="text-3xl font-black text-slate-800">3</p>
              <p className="text-xs text-slate-400 mt-2">Trong vòng 7 ngày tới</p>
            </div>
          </Link>

          <Link to="/guide/profile" className="block no-underline">
            <div className="p-6 rounded-[1.5rem] bg-slate-50 hover:bg-white transition-colors border border-slate-100">
              <h3 className="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Hồ sơ</h3>
              <p className="text-lg font-bold text-slate-800">Nguyễn Văn A</p>
              <p className="text-xs text-slate-400 mt-2">Email: guide@example.com</p>
            </div>
          </Link>
        </div>

        <div className="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="p-6 rounded-[1.5rem] bg-white border border-slate-100">
            <h4 className="text-sm font-bold text-slate-600 mb-3">Hoạt động gần đây</h4>
            <ul className="text-sm text-slate-500 space-y-2">
              <li>- Xác nhận đặt chỗ #12345</li>
              <li>- Cập nhật lịch trình Tour Huế 20/02</li>
              <li>- Thêm ảnh cho Tour Đà Nẵng</li>
            </ul>
          </div>

          <div className="p-6 rounded-[1.5rem] bg-white border border-slate-100">
            <h4 className="text-sm font-bold text-slate-600 mb-3">Gợi ý</h4>
            <p className="text-sm text-slate-500">Cập nhật trạng thái đặt chỗ thường xuyên để khách hàng nắm bắt thông tin.</p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
