import React from "react";
import { Link, useLocation } from "react-router-dom";
import { LayoutDashboard, CalendarCheck, Map, User, LogOut, ChevronLeft, ChevronRight, Sailboat } from "lucide-react";

const NavItem = ({ icon, text, path, isOpen }) => {
  const location = useLocation();
  const active = location.pathname === path || (path !== "/guide" && location.pathname.startsWith(path));

  return (
    <Link to={path} className={`relative flex items-center py-2.5 px-3 my-1.5 font-medium rounded-xl cursor-pointer transition-all duration-200 group ${active ? "bg-blue-50 text-blue-600 shadow-sm" : "hover:bg-gray-50 text-gray-500 hover:text-gray-700"}`}>
      <span className={`${active ? "text-blue-600" : "text-gray-400 group-hover:text-gray-600"}`}>{icon}</span>
      <span className={`overflow-hidden transition-all duration-300 ${isOpen ? "w-40 ml-3" : "w-0"}`}>{text}</span>
    </Link>
  );
};

const GuideSidebar = ({ isOpen, setIsOpen }) => {
  const menu = [
    { icon: <LayoutDashboard size={20} />, text: "Dashboard", path: "/guide" },
    { icon: <CalendarCheck size={20} />, text: "Đặt chỗ", path: "/guide/bookings" },
    { icon: <Map size={20} />, text: "Tour", path: "/guide/tours" },
    { icon: <User size={20} />, text: "Hồ sơ", path: "/guide/profile" },
  ];

  return (
    <aside className={`h-screen sticky top-0 transition-all duration-300 ${isOpen ? "w-64" : "w-20"}`}>
      <div className="flex flex-col h-full bg-white border-r border-gray-100 shadow-sm">
        <div className="p-4 mb-2 flex items-center justify-between h-20">
          <Link to="/guide" className={`flex items-center gap-3 overflow-hidden transition-all ${isOpen ? "w-auto" : "w-0"}`}>
            <div className="bg-blue-600 p-2 rounded-xl text-white"><Sailboat size={24} /></div>
            <span className="font-bold text-xl tracking-tight text-gray-800 whitespace-nowrap">Guide<span className="text-blue-600">Ease</span></span>
          </Link>
          <button onClick={() => setIsOpen(!isOpen)} className="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 transition-colors">
            {isOpen ? <ChevronLeft size={20} /> : <ChevronRight size={20} />}
          </button>
        </div>

        <div className="flex-1 px-3 overflow-y-auto no-scrollbar">
          <div className="mb-6">
            <p className={`px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2 ${isOpen ? '' : 'hidden'}`}>Hướng dẫn</p>
            <div className="flex flex-col">
              {menu.map((m) => (
                <NavItem key={m.path} icon={m.icon} text={m.text} path={m.path} isOpen={isOpen} />
              ))}
            </div>
          </div>
        </div>

        <div className="p-4 border-t border-gray-50 bg-gray-50/50">
          <div className={`flex items-center ${isOpen ? '' : 'justify-center'}`}>
            <img src="https://ui-avatars.com/api/?name=Guide+User&background=0D8ABC&color=fff" alt="Avatar" className="w-10 h-10 rounded-xl object-cover shadow-sm" />
            {isOpen && (
              <div className="ml-3 flex-1 overflow-hidden">
                <h4 className="text-sm font-semibold text-gray-800 truncate">Guide User</h4>
                <p className="text-xs text-gray-500 truncate">guide@example.com</p>
              </div>
            )}
          </div>
          {isOpen && (
            <button className="mt-4 flex items-center justify-center gap-2 w-full py-2 text-sm font-medium text-red-500 hover:bg-red-50 rounded-lg transition-colors">
              <LogOut size={16} />
              <span>Đăng xuất</span>
            </button>
          )}
        </div>
      </div>
    </aside>
  );
};

export default GuideSidebar;
