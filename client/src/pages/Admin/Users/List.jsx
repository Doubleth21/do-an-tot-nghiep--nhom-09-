import React, { useState, useEffect } from "react";
import {
    Search, UserPlus, Shield, Edit2, Trash2,
    Loader2, Lock, Unlock, Filter, AlertCircle, X
} from "lucide-react";
import { Link } from "react-router-dom";
import { getUsers, toggleUserStatus, deleteUser } from "../../../api/user";
import toast, { Toaster } from "react-hot-toast";

const UserList = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState("");
    const [roleFilter, setRoleFilter] = useState("all");

    // Modal State
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [userToDelete, setUserToDelete] = useState(null);

    const fetchUsers = async () => {
        try {
            setLoading(true);
            const res = await getUsers();
            setUsers(res.data || []);
        } catch (error) {
            toast.error("Không thể tải danh sách tài khoản");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => { fetchUsers(); }, []);

    // 1. Mở Modal xác nhận - Sử dụng .id thay vì .user_id
    const handleOpenDeleteModal = (id, name) => {
        setUserToDelete({ id, name });
        setIsModalOpen(true);
    };

    // 2. Thực hiện Xóa - Đã sửa lỗi Filter mảng
    const confirmDelete = async () => {
        if (!userToDelete) return;

        try {
            await deleteUser(userToDelete.id);
            toast.success(`Đã xóa tài khoản "${userToDelete.name}" thành công!`, {
                style: { borderRadius: '15px', background: '#333', color: '#fff' },
                icon: '🗑️',
            });
            // SỬA: Lọc dựa trên trường 'id'
            setUsers(users.filter(u => u.id !== userToDelete.id));
        } catch (error) {
            toast.error("Lỗi: Không thể xóa tài khoản này");
        } finally {
            setIsModalOpen(false);
            setUserToDelete(null);
        }
    };

    // 3. Cập nhật trạng thái - Đã sửa truyền tham số .id
    const handleToggleStatus = async (user) => {
        try {
            // SỬA: Truyền user.id thay vì user.user_id
            await toggleUserStatus(user.id, user.status);
            toast.success("Cập nhật trạng thái thành công");
            fetchUsers();
        } catch (error) {
            toast.error("Lỗi khi cập nhật trạng thái");
        }
    };

    const filteredUsers = users.filter(u => {
        const matchesSearch = u.fullname.toLowerCase().includes(searchTerm.toLowerCase()) ||
            u.username.toLowerCase().includes(searchTerm.toLowerCase());
        const matchesRole = roleFilter === "all" || u.role === roleFilter;
        return matchesSearch && matchesRole;
    });

    return (
        <div className="p-6 space-y-6 relative">
            <Toaster position="top-right" reverseOrder={false} />

            {/* HEADER */}
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-black text-slate-800 tracking-tight uppercase">Quản lý Tài khoản</h1>
                    <p className="text-sm text-slate-500 font-medium">Hệ thống có {users.length} thành viên</p>
                </div>
                <Link to="/admin/users/add" className="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-blue-100">
                    <UserPlus size={20} /> Thêm mới
                </Link>
            </div>

            {/* SEARCH & FILTER */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
                <div className="md:col-span-2 relative">
                    <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={20} />
                    <input type="text" placeholder="Tìm kiếm tên hoặc username..." className="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 ring-blue-500/20 outline-none font-medium"
                        value={searchTerm} onChange={(e) => setSearchTerm(e.target.value)} />
                </div>
                <select className="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl outline-none font-bold text-slate-600 appearance-none cursor-pointer"
                    value={roleFilter} onChange={(e) => setRoleFilter(e.target.value)}>
                    <option value="all">Tất cả vai trò</option>
                    <option value="admin">Admin</option>
                    <option value="guide">Hướng dẫn viên</option>
                    <option value="customer">Khách hàng</option>
                </select>
            </div>

            {/* TABLE */}
            <div className="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <table className="w-full text-left">
                    <thead className="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th className="px-6 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">Tên người dùng</th>
                            <th className="px-6 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Vai trò</th>
                            <th className="px-6 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Trạng thái</th>
                            <th className="px-6 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-50">
                        {loading ? (
                            <tr><td colSpan="4" className="py-20 text-center"><Loader2 className="animate-spin mx-auto text-blue-500" size={40} /></td></tr>
                        ) : filteredUsers.map((user) => (
                            <tr key={user.id} className="hover:bg-slate-50/50 transition-colors">
                                <td className="px-6 py-4">
                                    <div className="flex items-center gap-3">
                                        <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md">
                                            {user.fullname?.charAt(0) || "U"}
                                        </div>
                                        <div>
                                            <div className="font-bold text-slate-800">{user.fullname}</div>
                                            <div className="text-xs text-slate-400 font-medium">@{user.username}</div>
                                        </div>
                                    </div>
                                </td>
                                <td className="px-6 py-4 text-center">
                                    <span className={`px-3 py-1 rounded-full text-[10px] font-black uppercase border ${user.role === 'admin' ? 'bg-purple-50 text-purple-600 border-purple-100' :
                                            user.role === 'guide' ? 'bg-orange-50 text-orange-600 border-orange-100' :
                                                'bg-blue-50 text-blue-600 border-blue-100'
                                        }`}>
                                        {user.role}
                                    </span>
                                </td>
                                <td className="px-6 py-4 text-center">
                                    <button onClick={() => handleToggleStatus(user)}
                                        className={`inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-bold transition-all ${user.status === 1 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50'}`}>
                                        {user.status === 1 ? <Unlock size={14} /> : <Lock size={14} />}
                                        {user.status === 1 ? 'Hoạt động' : 'Đã khóa'}
                                    </button>
                                </td>
                                <td className="px-6 py-4 text-right">
                                    <div className="flex justify-end gap-2">
                                        {/* SỬA: Đường dẫn edit dùng user.id */}
                                        <Link to={`/admin/users/edit/${user.id}`} className="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                            <Edit2 size={18} />
                                        </Link>
                                        {/* SỬA: Hàm xóa dùng user.id */}
                                        <button onClick={() => handleOpenDeleteModal(user.id, user.fullname)} className="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                            <Trash2 size={18} />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            {/* DELETE MODAL */}
            {isModalOpen && (
                <div className="fixed inset-0 z-[999] flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm animate-in fade-in duration-300" onClick={() => setIsModalOpen(false)}></div>
                    <div className="relative bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl animate-in zoom-in-95 duration-300">
                        <button onClick={() => setIsModalOpen(false)} className="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors"><X size={24} /></button>
                        <div className="flex flex-col items-center text-center space-y-4">
                            <div className="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center shadow-inner">
                                <AlertCircle size={40} strokeWidth={2.5} />
                            </div>
                            <div>
                                <h3 className="text-xl font-black text-slate-800">Xác nhận xóa tài khoản?</h3>
                                <p className="text-slate-500 mt-2 font-medium px-4">
                                    Bạn đang thực hiện xóa tài khoản <span className="text-rose-600 font-bold">"{userToDelete?.name}"</span>. Hành động này không thể hoàn tác.
                                </p>
                            </div>
                            <div className="flex gap-3 w-full mt-4">
                                <button onClick={() => setIsModalOpen(false)} className="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all">Hủy bỏ</button>
                                <button onClick={confirmDelete} className="flex-1 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-2xl shadow-lg shadow-rose-200 transition-all">Xóa ngay</button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default UserList;