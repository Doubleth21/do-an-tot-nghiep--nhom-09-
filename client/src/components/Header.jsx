import React, { useState } from "react";
import { Link } from "react-router-dom";

export default function Header() {
  const [mobileOpen, setMobileOpen] = useState(false);

  return (
    <header className="bg-white shadow-sm">
      <div className="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <Link to="/" className="inline-flex items-center gap-3">
          <img src={encodeURI('/logo.png')} alt="TourEase" className="h-12 md:h-14" />
        </Link>

        <div className="hidden md:flex items-center gap-8">
          <nav className="flex items-center gap-6">
            <Link to="/about" className="text-sm text-slate-600 hover:text-slate-800">Về chúng tôi</Link>
            <Link to="/tours" className="text-sm text-slate-600 hover:text-slate-800">Tour trong nước</Link>
            <Link to="/news" className="text-sm text-slate-600 hover:text-slate-800">Tin tức</Link>
            <Link to="/contact" className="text-sm text-slate-600 hover:text-slate-800">Liên hệ</Link>
          </nav>
        </div>

        <button
          onClick={() => setMobileOpen(!mobileOpen)}
          className="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100"
          aria-label="Open menu"
        >
          <span className="block w-6 h-0.5 bg-slate-700 mb-1" />
          <span className="block w-6 h-0.5 bg-slate-700 mb-1" />
          <span className="block w-6 h-0.5 bg-slate-700" />
        </button>
      </div>

      {mobileOpen && (
        <div className="md:hidden bg-white border-t border-slate-100 shadow-sm">
          <div className="px-6 py-4 flex flex-col gap-3">
            <Link to="/about" onClick={() => setMobileOpen(false)} className="text-sm text-slate-700">Về chúng tôi</Link>
            <Link to="/tours" onClick={() => setMobileOpen(false)} className="text-sm text-slate-700">Tour trong nước</Link>
            <Link to="/news" onClick={() => setMobileOpen(false)} className="text-sm text-slate-700">Tin tức</Link>
            <Link to="/contact" onClick={() => setMobileOpen(false)} className="text-sm text-slate-700">Liên hệ</Link>
            <hr className="my-2" />
            <Link to="/guide/login" onClick={() => setMobileOpen(false)} className="text-sm text-slate-700">Hướng dẫn viên</Link>
            <Link to="/admin" onClick={() => setMobileOpen(false)} className="text-sm text-slate-700">Quản trị</Link>
          </div>
        </div>
      )}
    </header>
  );
}
