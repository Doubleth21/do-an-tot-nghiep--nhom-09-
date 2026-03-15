import React from "react";
import { Link } from "react-router-dom";
import Header from "../../components/Header";
import Footer from "../../components/Footer";

const sampleTours = [
  { id: 1, title: "Hành trình Huế - Hội An", price: "1.200.000đ", days: "2 ngày", place: "Huế", img: "/images/hero-800x450.jpg", rating: 4.7, reviews: 124, badge: "Hot" },
  { id: 2, title: "Đà Nẵng biển xanh", price: "900.000đ", days: "1 ngày", place: "Đà Nẵng", img: "/images/hero-800x450.jpg", rating: 4.5, reviews: 98, badge: "Popular" },
  { id: 3, title: "Hà Nội khám phá", price: "1.500.000đ", days: "3 ngày", place: "Hà Nội", img: "/images/hero-800x450.jpg", rating: 4.8, reviews: 210, badge: "Featured" },
  { id: 4, title: "Sài Gòn ẩm thực", price: "800.000đ", days: "1 ngày", place: "TP.HCM", img: "/images/hero-800x450.jpg", rating: 4.4, reviews: 56, badge: "New" },
  { id: 5, title: "Đà Lạt lãng mạn", price: "1.000.000đ", days: "2 ngày", place: "Đà Lạt", img: "/images/hero-800x450.jpg", rating: 4.6, reviews: 78, badge: "Popular" },
  { id: 6, title: "Hội An cổ kính", price: "800.000đ", days: "1 ngày", place: "Hội An", img: "/images/hero-800x450.jpg", rating: 4.3, reviews: 45, badge: "Hot" },
];

export default function Home() {
  return (
    <div className="min-h-screen bg-slate-50">
      <Header />

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

      {/* Why choose us */}
      <section className="max-w-7xl mx-auto px-6 py-12">
        <h3 className="text-2xl font-bold text-slate-800 mb-6">Tại sao chọn TourEase</h3>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div className="bg-white p-6 rounded-xl shadow-sm text-center">
            <div className="text-3xl mb-3">💸</div>
            <h4 className="font-bold text-slate-800">Giá cạnh tranh</h4>
            <p className="text-sm text-slate-500 mt-2">Đàm phán trực tiếp, nhiều ưu đãi và chương trình khuyến mãi.</p>
          </div>

          <div className="bg-white p-6 rounded-xl shadow-sm text-center">
            <div className="text-3xl mb-3">🧭</div>
            <h4 className="font-bold text-slate-800">Hướng dẫn chuyên nghiệp</h4>
            <p className="text-sm text-slate-500 mt-2">Đội ngũ hướng dẫn viên được đào tạo, am hiểu địa phương.</p>
          </div>

          <div className="bg-white p-6 rounded-xl shadow-sm text-center">
            <div className="text-3xl mb-3">🔁</div>
            <h4 className="font-bold text-slate-800">Hủy linh hoạt</h4>
            <p className="text-sm text-slate-500 mt-2">Chính sách hủy minh bạch, hoàn tiền nhanh chóng khi đủ điều kiện.</p>
          </div>

          <div className="bg-white p-6 rounded-xl shadow-sm text-center">
            <div className="text-3xl mb-3">📞</div>
            <h4 className="font-bold text-slate-800">Hỗ trợ 24/7</h4>
            <p className="text-sm text-slate-500 mt-2">Tư vấn và hỗ trợ xử lý sự cố mọi lúc, mọi nơi.</p>
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
            <div key={t.id} className="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm card-hover transition-transform duration-200">
              <div className="relative">
                <img src={t.img} alt={t.title} className="w-full h-44 object-cover" />
                <div className="absolute top-3 left-3 px-3 py-1 rounded-full text-xs text-white badge-gradient">{t.badge}</div>
                <div className="absolute top-3 right-3 bg-white/80 rounded-full px-2 py-1 text-sm">{t.rating} <span className="rating-star">★</span></div>
              </div>
              <div className="p-4">
                <div className="flex items-start justify-between gap-3">
                  <div>
                    <h4 className="text-lg font-bold text-slate-800">{t.title}</h4>
                    <p className="text-sm text-slate-500">{t.place} • {t.days}</p>
                    <p className="text-xs text-slate-400 mt-1">{t.reviews} đánh giá</p>
                  </div>
                  <div className="text-blue-600 font-extrabold text-lg">{t.price}</div>
                </div>
                <div className="mt-4 flex gap-2">
                  <Link to={`/tours/${t.id}`} className="text-sm px-3 py-2 border rounded-2xl">Chi tiết</Link>
                  <button className="ml-auto bg-gradient-to-r from-blue-600 to-teal-500 text-white text-sm px-4 py-2 rounded-2xl">Đặt ngay</button>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* Promotional Banner */}
      <section className="max-w-7xl mx-auto px-6 mb-12">
        <div className="bg-gradient-to-r from-blue-600 to-teal-500 rounded-2xl overflow-hidden shadow-lg flex flex-col lg:flex-row items-center">
          <div className="p-8 lg:p-12 text-center lg:text-left text-white flex-1">
            <h4 className="text-2xl lg:text-3xl font-extrabold mb-2">Ưu đãi đặt sớm — Giảm đến 25%</h4>
            <p className="text-sm lg:text-base text-blue-100/90 mb-4">Đặt tour trước 30 ngày để nhận ưu đãi đặc biệt cho các hành trình được chọn. Chỗ có hạn — đặt ngay!</p>
            <div className="flex items-center justify-center lg:justify-start gap-3">
              <Link to="/tours" className="bg-white text-blue-600 font-semibold px-4 py-2 rounded-lg">Xem ưu đãi</Link>
              <a href="#" className="text-sm text-blue-100 underline">Tìm hiểu thêm</a>
            </div>
          </div>

          <div className="w-full lg:w-1/3">
            <img src="/hero.svg" alt="promo" className="w-full h-40 lg:h-full object-cover" />
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
}
