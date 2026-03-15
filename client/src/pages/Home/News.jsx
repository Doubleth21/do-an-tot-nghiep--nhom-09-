import React from "react";
import Header from "../../components/Header";
import Footer from "../../components/Footer";

const samplePosts = [
  { id: 1, title: "5 điểm đến không thể bỏ qua ở Hà Nội", date: "2026-02-10", excerpt: "Khám phá những địa điểm văn hoá và ẩm thực đặc sắc tại thủ đô." },
  { id: 2, title: "Mẹo du lịch tiết kiệm cho gia đình", date: "2026-01-22", excerpt: "Lên kế hoạch, chọn tour hợp lý và tận dụng khuyến mãi để tiết kiệm chi phí." },
  { id: 3, title: "Du lịch bền vững: Hướng dẫn cơ bản", date: "2025-12-05", excerpt: "Các cách để giảm tác động môi trường khi đi du lịch." },
];

export default function News() {
  return (
    <>
      <Header />

      <div className="min-h-screen bg-slate-50">
        <div className="max-w-6xl mx-auto p-6">
          <header className="mb-6">
            <h1 className="text-3xl font-extrabold">Tin tức & Cẩm nang</h1>
            <p className="text-slate-600 mt-2">Cập nhật bài viết, mẹo du lịch và tin khuyến mãi mới nhất từ TourEase.</p>
          </header>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {samplePosts.map((p) => (
              <article key={p.id} className="bg-white p-6 rounded-xl shadow-sm">
                <h3 className="font-bold text-lg mb-1">{p.title}</h3>
                <div className="text-xs text-slate-400 mb-3">{p.date}</div>
                <p className="text-sm text-slate-600">{p.excerpt}</p>
                <div className="mt-4">
                  <a className="text-sm text-blue-600" href="#">Đọc tiếp →</a>
                </div>
              </article>
            ))}
          </div>
        </div>
      </div>

      <Footer />
    </>
  );
}

