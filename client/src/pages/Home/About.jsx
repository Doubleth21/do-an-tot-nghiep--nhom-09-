import React from "react";
import Header from "../../components/Header";
import Footer from "../../components/Footer";

export default function About() {
  return (
    <>
      <Header />

      <div className="min-h-screen bg-slate-50">
        <div className="max-w-6xl mx-auto p-6">
          <header className="mb-8">
            <h1 className="text-3xl font-extrabold text-slate-900">Về TourEase</h1>
            <p className="text-slate-600 mt-2">TourEase kết nối du khách với trải nghiệm địa phương chất lượng cao. Chúng tôi tạo ra hành trình an toàn, giá hợp lý và dịch vụ tận tâm.</p>
          </header>

          <section className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div className="bg-white p-6 rounded-xl shadow-sm">
              <h3 className="font-bold mb-2">Sứ mệnh</h3>
              <p className="text-sm text-slate-500">Mang đến trải nghiệm du lịch đáng nhớ, kết nối cộng đồng và thúc đẩy du lịch bền vững.</p>
            </div>

            <div className="bg-white p-6 rounded-xl shadow-sm">
              <h3 className="font-bold mb-2">Tầm nhìn</h3>
              <p className="text-sm text-slate-500">Trở thành nền tảng đặt tour được tin cậy nhất trong khu vực, với dịch vụ chuyên nghiệp và giá trị rõ rệt cho khách hàng.</p>
            </div>

            <div className="bg-white p-6 rounded-xl shadow-sm">
              <h3 className="font-bold mb-2">Giá trị cốt lõi</h3>
              <ul className="text-sm text-slate-500 list-disc list-inside">
                <li>Minh bạch</li>
                <li>Chất lượng</li>
                <li>Hỗ trợ tận tâm</li>
              </ul>
            </div>
          </section>

          <section className="bg-white p-6 rounded-xl shadow-sm">
            <h3 className="text-xl font-bold mb-3">Đội ngũ của chúng tôi</h3>
            <p className="text-sm text-slate-500">Chúng tôi là một nhóm những người đam mê du lịch, công nghệ và trải nghiệm khách hàng. Đội ngũ bao gồm quản lý sản phẩm, marketing, hỗ trợ khách hàng và mạng lưới hướng dẫn viên địa phương.</p>
          </section>
        </div>
      </div>

      <Footer />
    </>
  );
}
