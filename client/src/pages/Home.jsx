import React from "react";
import { Link } from "react-router-dom";

const sampleTours = [
  { id: 1, title: "Hành trình Huế - Hội An", price: "1.200.000đ", days: "2 ngày", place: "Huế" },
  { id: 2, title: "Đà Nẵng biển xanh", price: "900.000đ", days: "1 ngày", place: "Đà Nẵng" },
  { id: 3, title: "Hà Nội khám phá", price: "1.500.000đ", days: "3 ngày", place: "Hà Nội" },
  { id: 4, title: "Sài Gòn ẩm thực", price: "800.000đ", days: "1 ngày", place: "TP.HCM" },
  { id: 5, title: "Đà Lạt lãng mạn", price: "1.000.000đ", days: "2 ngày", place: "Đà Lạt" },
  { id: 6, title: "Hội An cổ kính", price: "800.000đ", days: "1 ngày", place: "Hội An" },
];

export default function Home() {
  return (
    <div className="min-h-screen bg-slate-50">
      <header className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
          <h1 className="text-2xl font-bold text-slate-800">TourEase</h1>
          <nav className="space-x-4">
            <Link to="/guide/login" className="text-sm text-slate-600 hover:text-slate-800">Hướng dẫn viên</Link>
            <Link to="/admin" className="text-sm text-slate-600 hover:text-slate-800">Quản trị</Link>
          </nav>
        </div>
      </header>

      {/* Hero with search */}
      <section className="bg-gradient-to-r from-blue-50 to-white">
        <div className="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
          <div>
            <h2 className="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-4">Khám phá chuyến đi hoàn hảo cho bạn</h2>
            <p className="text-slate-600 mb-6">Tìm và đặt tour nhanh chóng — nhiều lựa chọn, giá cả hợp lý và hướng dẫn chuyên nghiệp.</p>

            <form className="bg-white p-4 rounded-2xl shadow-sm grid grid-cols-1 md:grid-cols-3 gap-3">
              <input className="col-span-1 md:col-span-1 px-4 py-3 border rounded-lg" placeholder="Bạn muốn đi đâu?" />
              <input className="col-span-1 md:col-span-1 px-4 py-3 border rounded-lg" placeholder="Ngày khởi hành" />
              <button className="col-span-1 md:col-span-1 bg-blue-600 text-white px-4 py-3 rounded-lg">Tìm kiếm</button>
            </form>

            <div className="mt-6 flex gap-4 flex-wrap text-sm text-slate-500">
              <div>Giá từ <strong className="text-slate-800">500.000đ</strong></div>
              <div>Hủy miễn phí</div>
              <div>Hỗ trợ 24/7</div>
            </div>
          </div>

          <div className="hidden lg:block">
            <div className="rounded-2xl overflow-hidden shadow-lg">
              <img src="/hero.svg" alt="hero" className="w-full h-80 object-cover" />
            </div>
          </div>
        </div>
      </section>

      {/* Categories */}
      <section className="max-w-7xl mx-auto px-6 py-12">
        <h3 className="text-2xl font-bold text-slate-800 mb-6">Khám phá theo danh mục</h3>
        <div className="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
          {[
            "Biển",
            "Di sản",
            "Ẩm thực",
            "Núi",
            "Phiêu lưu",
            "Thành phố",
          ].map((c) => (
            <div key={c} className="bg-white p-4 rounded-lg text-center shadow-sm">
              <div className="h-12 w-12 mx-auto mb-2 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">🏖️</div>
              <div className="text-sm font-medium text-slate-700">{c}</div>
            </div>
          ))}
        </div>
      </section>

      {/* Featured Tours */}
      <section className="max-w-7xl mx-auto px-6 pb-12">
        <div className="flex items-center justify-between mb-6">
          <h3 className="text-2xl font-bold text-slate-800">Tour nổi bật</h3>
          <Link to="/tours" className="text-sm text-blue-600">Xem tất cả</Link>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {sampleTours.map((t) => (
            <div key={t.id} className="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
              <div className="h-44 bg-slate-100" />
              <div className="p-4">
                <div className="flex items-center justify-between">
                  <div>
                    <h4 className="text-lg font-bold text-slate-800">{t.title}</h4>
                    <p className="text-sm text-slate-500">{t.place} • {t.days}</p>
                  </div>
                  <div className="text-blue-600 font-extrabold">{t.price}</div>
                </div>
                <div className="mt-4 flex gap-2">
                  <Link to={`/tours/${t.id}`} className="text-sm px-3 py-2 border rounded-2xl">Chi tiết</Link>
                  <button className="ml-auto bg-blue-600 text-white text-sm px-4 py-2 rounded-2xl">Đặt ngay</button>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-slate-900 text-slate-300">
        <div className="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <h5 className="text-white font-bold mb-2">TourEase</h5>
            <p className="text-sm">Hệ thống quản lý tour — trải nghiệm tốt nhất cho khách hàng và hướng dẫn viên.</p>
          </div>
          <div>
            <h6 className="font-bold text-white mb-2">Liên hệ</h6>
            <p className="text-sm">Email: support@tourease.local</p>
            <p className="text-sm">Hotline: 1900 0000</p>
          </div>
          <div>
            <h6 className="font-bold text-white mb-2">Theo dõi</h6>
            <div className="flex gap-3">
              <div className="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center">f</div>
              <div className="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center">in</div>
              <div className="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center">yt</div>
            </div>
          </div>
        </div>
        <div className="text-center text-slate-500 py-4">© 2026 TourEase</div>
      </footer>
    </div>
  );
}
