import { useState } from "react";
import { Outlet } from "react-router-dom";
import GuideSidebar from "../components/GuideSidebar";

export default function GuideLayout() {
  const [isOpen, setIsOpen] = useState(true);

  return (
    <div className="flex min-h-screen bg-slate-50/50">
      <GuideSidebar isOpen={isOpen} setIsOpen={setIsOpen} />

      <div className="flex-1 flex flex-col">
        <header className="h-20 bg-transparent flex items-center px-8">
          <h2 className="text-2xl font-bold text-gray-800">Guide</h2>
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
