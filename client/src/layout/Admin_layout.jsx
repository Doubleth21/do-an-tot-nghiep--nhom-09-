import { useState } from "react";
import { Outlet } from "react-router-dom";
import Sidebar from "../components/Sidebar"; // Đường dẫn tới file sidebar trên

export default function AdminLayout() {
    const [isOpen, setIsOpen] = useState(true);
    const [activePage, setActivePage] = useState("Dashboard");

    return (
        <div className="flex min-h-screen bg-slate-50/50">
            {/* SIDEBAR CỐ ĐỊNH */}
            <Sidebar
                isOpen={isOpen}
                setIsOpen={setIsOpen}
                activePage={activePage}
                setActivePage={setActivePage}
            />

            {/* NỘI DUNG CHÍNH */}
            <div className="flex-1 flex flex-col">
                {/* Header phía trên (tùy chọn) */}
                <header className="h-20 bg-transparent flex items-center px-8">
                    <h2 className="text-2xl font-bold text-gray-800">{activePage}</h2>
                </header>

                <main className="p-8 pt-0">
                    <div className="bg-white rounded-3xl p-6 min-h-[calc(100vh-120px)] shadow-sm border border-gray-100">
                        <Outlet />
                    </div>
                </main>
            </div>
        </div>
    );
}