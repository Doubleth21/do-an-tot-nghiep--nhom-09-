import React from "react";
import { Link, useLocation } from "react-router-dom"; // Thêm Link và useLocation
import {
    LayoutDashboard,
    CalendarCheck,
    Map,
    Users,
    BarChart3,
    Settings,
    ChevronLeft,
    ChevronRight,
    Sailboat,
    Tag,
    LogOut
} from "lucide-react";

const NavItem = ({ icon, text, path, isOpen }) => {
    const location = useLocation();
    // Kiểm tra xem đường dẫn hiện tại có khớp với path của item không
    const active = location.pathname === path || (path !== "/admin" && location.pathname.startsWith(path));

    return (
        <Link
            to={path}
            className={`
                relative flex items-center py-2.5 px-3 my-1.5
                font-medium rounded-xl cursor-pointer
                transition-all duration-200 group
                ${active
                    ? "bg-blue-50 text-blue-600 shadow-sm"
                    : "hover:bg-gray-50 text-gray-500 hover:text-gray-700"
                }
            `}
        >
            <span className={`${active ? "text-blue-600" : "text-gray-400 group-hover:text-gray-600"}`}>
                {icon}
            </span>

            <span className={`overflow-hidden transition-all duration-300 ${isOpen ? "w-40 ml-3" : "w-0"}`}>
                {text}
            </span>

            {active && isOpen && (
                <div className="absolute right-3 w-1.5 h-1.5 rounded-full bg-blue-600" />
            )}

            {!isOpen && (
                <div className="absolute left-full rounded-md px-2 py-1 ml-6 bg-gray-800 text-white text-xs invisible opacity-20 -translate-x-3 transition-all group-hover:visible group-hover:opacity-100 group-hover:translate-x-0 z-50 whitespace-nowrap">
                    {text}
                </div>
            )}
        </Link>
    );
};

const Sidebar = ({ isOpen, setIsOpen }) => {
    // Thêm trường 'path' để định tuyến
    const menuGroups = [
        {
            group: "Chung",
            items: [
                { icon: <LayoutDashboard size={20} />, text: "Dashboard", path: "/admin" },
                { icon: <BarChart3 size={20} />, text: "Thống kê", path: "/admin/analytics" },
            ]
        },
        {
            group: "Quản lý dịch vụ",
            items: [
                { icon: <Map size={20} />, text: "Danh sách Tour", path: "/admin/tours" },
                { icon: <Tag size={20} />, text: "Danh mục Tour", path: "/admin/categories" },
                { icon: <CalendarCheck size={20} />, text: "Đơn đặt chỗ", path: "/admin/bookings" },
            ]
        },
        {
            group: "Người dùng",
            items: [
                { icon: <Users size={20} />, text: "Khách hàng", path: "/admin/customers" },
                { icon: <Settings size={20} />, text: "Cài đặt", path: "/admin/settings" },
            ]
        }
    ];

    return (
        <aside className={`h-screen sticky top-0 transition-all duration-300 ${isOpen ? "w-64" : "w-20"}`}>
            <div className="flex flex-col h-full bg-white border-r border-gray-100 shadow-sm">

                {/* Logo Section */}
                <div className="p-4 mb-2 flex items-center justify-between h-20">
                    <Link to="/admin" className={`flex items-center gap-3 overflow-hidden transition-all ${isOpen ? "w-auto" : "w-0"}`}>
                        <div className="bg-blue-600 p-2 rounded-xl text-white">
                            <Sailboat size={24} />
                        </div>
                        <span className="font-bold text-xl tracking-tight text-gray-800 whitespace-nowrap">
                            Tour<span className="text-blue-600">Ease</span>
                        </span>
                    </Link>
                    <button
                        onClick={() => setIsOpen(!isOpen)}
                        className="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 transition-colors"
                    >
                        {isOpen ? <ChevronLeft size={20} /> : <ChevronRight size={20} />}
                    </button>
                </div>

                {/* Navigation Menu */}
                <div className="flex-1 px-3 overflow-y-auto no-scrollbar">
                    {menuGroups.map((group, idx) => (
                        <div key={idx} className="mb-6">
                            {isOpen && (
                                <p className="px-4 text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                    {group.group}
                                </p>
                            )}
                            <div className="flex flex-col">
                                {group.items.map((item) => (
                                    <NavItem
                                        key={item.text}
                                        icon={item.icon}
                                        text={item.text}
                                        path={item.path}
                                        isOpen={isOpen}
                                    />
                                ))}
                            </div>
                        </div>
                    ))}
                </div>

                {/* Footer User Profile */}
                <div className="p-4 border-t border-gray-50 bg-gray-50/50">
                    <div className={`flex items-center ${isOpen ? "" : "justify-center"}`}>
                        <img
                            src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff"
                            alt="Avatar"
                            className="w-10 h-10 rounded-xl object-cover shadow-sm"
                        />
                        {isOpen && (
                            <div className="ml-3 flex-1 overflow-hidden">
                                <h4 className="text-sm font-semibold text-gray-800 truncate">Admin Tour</h4>
                                <p className="text-xs text-gray-500 truncate">admin@tourease.com</p>
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

export default Sidebar;