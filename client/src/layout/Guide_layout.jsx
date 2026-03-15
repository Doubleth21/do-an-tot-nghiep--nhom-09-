import { useState, useEffect } from "react";
import { Outlet, useNavigate } from "react-router-dom";
import GuideSidebar from "../components/GuideSidebar";
import axiosClient from "../api/axios";

export default function GuideLayout() {
  const [isOpen, setIsOpen] = useState(true);
  const [showConfirm, setShowConfirm] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/guide/login");
      return;
    }
    axiosClient.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  }, [navigate]);

  return (
    <div className="flex min-h-screen bg-slate-50/50">
      <GuideSidebar isOpen={isOpen} setIsOpen={setIsOpen} />

      <div className="flex-1 flex flex-col">
        <header className="h-20 bg-transparent flex items-center justify-between px-8">
          <h2 className="text-2xl font-bold text-gray-800">Guide</h2>
          <div>
            <button
              onClick={() => setShowConfirm(true)}
              className="py-2 px-4 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-medium"
            >
              Đăng xuất
            </button>
          </div>
        </header>

        {showConfirm && (
          <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div className="bg-white rounded-xl p-6 w-full max-w-sm shadow-lg">
              <h3 className="text-lg font-bold mb-3">Xác nhận</h3>
              <p className="text-sm text-slate-600 mb-4">Bạn có chắc muốn đăng xuất không?</p>
              <div className="flex justify-end gap-3">
                <button
                  onClick={() => setShowConfirm(false)}
                  className="px-4 py-2 rounded-lg border border-slate-200 bg-white"
                >
                  Huỷ
                </button>
                <button
                  onClick={async () => {
                    try {
                      await axiosClient.post('/auth/logout');
                    } catch  {
                      // ignore
                    }
                    localStorage.removeItem('token');
                    delete axiosClient.defaults.headers.common['Authorization'];
                    setShowConfirm(false);
                    navigate('/guide/login');
                  }}
                  className="px-4 py-2 rounded-lg bg-rose-500 text-white"
                >
                  Đăng xuất
                </button>
              </div>
            </div>
          </div>
        )}

        <main className="p-8 pt-0">
          <div className="bg-white rounded-3xl p-6 min-h-[calc(100vh-120px)] shadow-sm border border-gray-100">
            <Outlet />
          </div>
        </main>
      </div>
    </div>
  );
}
