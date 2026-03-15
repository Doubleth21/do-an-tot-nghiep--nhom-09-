import React, { useState } from "react";
import Header from "../../components/Header";
import Footer from "../../components/Footer";

export default function Contact() {
  const [form, setForm] = useState({ name: "", email: "", message: "" });
  const [sent, setSent] = useState(false);

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });
  const handleSubmit = (e) => {
    e.preventDefault();
    // For now just simulate submit
    console.log("Contact form submitted:", form);
    setSent(true);
    setForm({ name: "", email: "", message: "" });
  };

  return (
    <>
      <Header />

      <div className="min-h-screen bg-slate-50">
        <div className="max-w-3xl mx-auto p-6">
          <h1 className="text-3xl font-extrabold mb-4">Liên hệ</h1>
          <p className="text-slate-600 mb-6">Gửi câu hỏi hoặc yêu cầu hỗ trợ cho chúng tôi. Chúng tôi sẽ phản hồi trong vòng 24 giờ làm việc.</p>

          {sent && (
            <div className="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">Cảm ơn bạn! Yêu cầu của bạn đã được gửi.</div>
          )}

          <form onSubmit={handleSubmit} className="bg-white p-6 rounded-xl shadow-sm">
            <div className="mb-4">
              <label className="block text-sm font-medium text-slate-700 mb-1">Họ và tên</label>
              <input name="name" value={form.name} onChange={handleChange} className="w-full px-4 py-2 border rounded" />
            </div>

            <div className="mb-4">
              <label className="block text-sm font-medium text-slate-700 mb-1">Email</label>
              <input name="email" value={form.email} onChange={handleChange} className="w-full px-4 py-2 border rounded" />
            </div>

            <div className="mb-4">
              <label className="block text-sm font-medium text-slate-700 mb-1">Nội dung</label>
              <textarea name="message" value={form.message} onChange={handleChange} rows={6} className="w-full px-4 py-2 border rounded" />
            </div>

            <div className="flex items-center justify-between">
              <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded">Gửi liên hệ</button>
              <div className="text-sm text-slate-500">Hoặc gọi ngay: <strong className="text-slate-800">1900 0000</strong></div>
            </div>
          </form>
        </div>
      </div>

      <Footer />
    </>
  );
}

