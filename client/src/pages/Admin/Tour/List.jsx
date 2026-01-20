import React, { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import {
    Search, Plus, Pencil, Trash2, ChevronLeft, ChevronRight,
    Loader2, AlertCircle, Building2, Image as ImageIcon
} from "lucide-react";
import { getTours, deleteTour } from "../../../api/tour";
import toast, { Toaster } from "react-hot-toast";

const TourList = () => {
    const navigate = useNavigate();
    const [tours, setTours] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState("");

    // Phân trang
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 6;

    // Xử lý Xóa
    const [deleteId, setDeleteId] = useState(null);
    const [isDeleting, setIsDeleting] = useState(false);

    // --- Lấy dữ liệu từ API ---
    const fetchTours = async () => {
        try {
            setLoading(true);
            const res = await getTours();
            setTours(res.data || []);
        } catch (error) {
            toast.error("Không thể kết nối với máy chủ");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchTours();
    }, []);

    // --- Logic xử lý hiển thị ---

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    };

    const filteredTours = tours.filter(tour =>
        tour.name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
        tour.supplier?.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const totalPages = Math.ceil(filteredTours.length / itemsPerPage);
    const currentItems = filteredTours.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);

    const handleConfirmDelete = async () => {
        if (!deleteId) return;
        setIsDeleting(true);
        try {
            await deleteTour(deleteId);
            toast.success("Đã xóa tour khỏi hệ thống");
            fetchTours();
            setDeleteId(null);
        } catch (error) {
            toast.error("Lỗi: Không thể xóa tour này");
        } finally {
            setIsDeleting(false);
        }
    };

    const StatusBadge = ({ status }) => {
        const config = {
            active: "bg-emerald-50 text-emerald-600 border-emerald-100",
            draft: "bg-slate-50 text-slate-500 border-slate-100",
            hidden: "bg-rose-50 text-rose-600 border-rose-100"
        };
        const text = { active: 'Đang bán', draft: 'Nháp', hidden: 'Đã ẩn' };
        return (
            <span className={`px-2.5 py-0.5 rounded-lg text-[11px] font-bold border uppercase tracking-wider ${config[status] || config.draft}`}>
                {text[status] || 'N/A'}
            </span>
        );
    };

    return (
        <div className="space-y-6 animate-in fade-in duration-500">
            <Toaster position="top-right" />

            {/* --- HEADER --- */}
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-extrabold text-slate-800 tracking-tight">Quản lý Tour</h1>
                    <p className="text-sm text-slate-500 font-medium">Hiển thị {filteredTours.length} chuyến đi trong hệ thống</p>
                </div>

                <div className="flex items-center gap-3">
                    <div className="relative group">
                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors" size={18} />
                        <input
                            type="text"
                            placeholder="Tìm tour, nhà cung cấp..."
                            className="pl-10 pr-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 w-72 transition-all bg-white shadow-sm font-medium"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                        />
                    </div>
                    <button
                        onClick={() => navigate("add")}
                        className="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-2xl transition-all shadow-lg shadow-blue-200 font-bold"
                    >
                        <Plus size={20} strokeWidth={3} />
                        <span>Thêm Tour</span>
                    </button>
                </div>
            </div>

            {/* --- TABLE CONTENT --- */}
            <div className="bg-white border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
                <div className="overflow-x-auto">
                    <table className="w-full text-left border-collapse">
                        <thead className="bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th className="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tour & Mô tả</th>
                                <th className="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Nhà cung cấp</th>
                                <th className="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Giá vé</th>
                                <th className="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Trạng thái</th>
                                <th className="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-50">
                            {loading ? (
                                <tr>
                                    <td colSpan="5" className="px-6 py-20 text-center">
                                        <Loader2 className="animate-spin text-blue-500 mx-auto mb-3" size={40} />
                                        <span className="text-slate-400 font-medium tracking-wide">Đang đồng bộ dữ liệu...</span>
                                    </td>
                                </tr>
                            ) : currentItems.length > 0 ? (
                                currentItems.map((tour) => (
                                    <tr key={tour.id} className="hover:bg-blue-50/20 transition-colors group">
                                        <td className="px-6 py-4 max-w-md">
                                            <div className="flex gap-4">
                                                <div className="h-20 w-28 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm border border-slate-100 bg-slate-50 relative">
                                                    <img
                                                        src={(tour.images && tour.images.length > 0) ? tour.images[0] : (tour.image || "https://placehold.co/600x400?text=No+Image")}
                                                        alt={tour.name}
                                                        className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                        onError={(e) => { e.target.src = "https://placehold.co/600x400?text=Error+Image"; }}
                                                    />
                                                    {tour.images?.length > 1 && (
                                                        <div className="absolute bottom-1 right-1 bg-black/60 backdrop-blur-sm text-white text-[9px] px-1.5 py-0.5 rounded-md flex items-center gap-1">
                                                            <ImageIcon size={10} />
                                                            {tour.images.length}
                                                        </div>
                                                    )}
                                                </div>
                                                <div className="flex flex-col justify-center">
                                                    <p className="font-bold text-slate-800 text-base leading-tight mb-1">{tour.name}</p>
                                                    <p className="text-slate-500 text-xs line-clamp-2 leading-relaxed max-w-[250px]">
                                                        {tour.description || "Chưa có mô tả cho tour này..."}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <div className="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 rounded-full text-slate-600">
                                                <Building2 size={14} />
                                                <span className="text-xs font-bold">{tour.supplier || 'N/A'}</span>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <span className="text-sm font-black text-blue-600">{formatCurrency(tour.price)}</span>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <StatusBadge status={tour.status} />
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            <div className="flex justify-end gap-1">
                                                <button
                                                    onClick={() => navigate(`edit/${tour.id}`)}
                                                    className="p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"
                                                >
                                                    <Pencil size={18} />
                                                </button>
                                                <button
                                                    onClick={() => setDeleteId(tour.id)}
                                                    className="p-2.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all"
                                                >
                                                    <Trash2 size={18} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="5" className="px-6 py-16 text-center text-slate-400 font-medium italic">
                                        Không tìm thấy tour nào phù hợp.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                {/* --- PAGINATION --- */}
                {filteredTours.length > itemsPerPage && (
                    <div className="px-8 py-5 border-t border-slate-50 flex items-center justify-between bg-slate-50/30">
                        <div className="text-xs font-bold text-slate-400 uppercase tracking-widest">
                            Trang {currentPage} / {totalPages}
                        </div>
                        <div className="flex gap-2">
                            <button
                                disabled={currentPage === 1}
                                onClick={() => setCurrentPage(prev => prev - 1)}
                                className="p-2.5 rounded-xl border bg-white hover:bg-slate-50 disabled:opacity-30 transition-all shadow-sm"
                            >
                                <ChevronLeft size={20} className="text-slate-600" />
                            </button>
                            <button
                                disabled={currentPage === totalPages}
                                onClick={() => setCurrentPage(prev => prev + 1)}
                                className="p-2.5 rounded-xl border bg-white hover:bg-slate-50 disabled:opacity-30 transition-all shadow-sm"
                            >
                                <ChevronRight size={20} className="text-slate-600" />
                            </button>
                        </div>
                    </div>
                )}
            </div>

            {/* --- DELETE CONFIRM MODAL --- */}
            {deleteId && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md animate-in fade-in duration-300">
                    <div className="bg-white rounded-[2.5rem] max-w-sm w-full p-8 shadow-2xl animate-in zoom-in-95 duration-200 text-center">
                        <div className="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-rose-50/50">
                            <AlertCircle className="text-rose-500" size={40} strokeWidth={2.5} />
                        </div>
                        <h3 className="text-2xl font-black text-slate-800 mb-2">Xác nhận xóa?</h3>
                        <p className="text-slate-500 font-medium text-sm px-4 mb-8">
                            Mọi dữ liệu liên quan đến Tour này sẽ bị gỡ bỏ vĩnh viễn khỏi hệ thống.
                        </p>
                        <div className="grid grid-cols-2 gap-3">
                            <button onClick={() => setDeleteId(null)} className="py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all">
                                Quay lại
                            </button>
                            <button onClick={handleConfirmDelete} disabled={isDeleting} className="py-4 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-rose-200 flex items-center justify-center">
                                {isDeleting ? <Loader2 className="animate-spin" size={20} /> : "Xóa ngay"}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default TourList;