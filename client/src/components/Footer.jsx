import React from "react";

export default function Footer() {
  return (
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
  );
}
