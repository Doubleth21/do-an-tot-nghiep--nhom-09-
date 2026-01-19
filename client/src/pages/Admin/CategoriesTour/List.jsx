import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom"; // Import Link để điều hướng
import {
    Search,
    Plus,
    Pencil,
    Trash2,
    ChevronLeft,
    ChevronRight,
    Loader2,
    AlertCircle
} from "lucide-react";
import { getCategories, deleteCategory } from "../../../api/categories";
import toast, { Toaster } from "react-hot-toast";

const CategoryList = () => {
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState("");

    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 5;

    const [deleteId, setDeleteId] = useState(null);
    const [isDeleting, setIsDeleting] = useState(false);

    const fetchCategories = async () => {
        try {
            setLoading(true);
            const res = await getCategories();
            setCategories(res.data);
        } catch (error) {
            toast.error("Không thể tải danh sách danh mục");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchCategories();
    }, []);

    const filteredCategories = categories.filter(cat =>
        cat.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        cat.description.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const totalPages = Math.ceil(filteredCategories.length / itemsPerPage);
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = filteredCategories.slice(indexOfFirstItem, indexOfLastItem);

    const confirmDelete = async () => {
        if (!deleteId) return;
        setIsDeleting(true);
        try {
            await deleteCategory(deleteId);
            toast.success("Xóa danh mục thành công!");
            setDeleteId(null);
            fetchCategories();
        } catch (error) {
            toast.error("Có lỗi xảy ra khi xóa");
        } finally {
            setIsDeleting(false);
        }
    };

    return (
        <div className="space-y-6">
            <Toaster position="top-right" />

            {/* Header & Search */}
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 className="text-2xl font-bold text-gray-800">Danh mục Tour</h1>
                    <p className="text-sm text-gray-500">Quản lý các loại hình du lịch của bạn</p>
                </div>

                <div className="flex items-center gap-3">
                    <div className="relative">
                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                        <input
                            type="text"
                            placeholder="Tìm danh mục..."
                            className="pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 w-64 transition-all"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                        />
                    </div>

                    {/* ĐƯỜNG DẪN ĐẾN TRANG THÊM MỚI */}
                    <Link
                        to="/admin/categories/add"
                        className="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-all shadow-md shadow-blue-100"
                    >
                        <Plus size={18} />
                        <span className="font-medium">Thêm mới</span>
                    </Link>
                </div>
            </div>

            {/* Table */}
            <div className="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                <table className="w-full text-left border-collapse">
                    <thead className="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th className="px-6 py-4 text-sm font-semibold text-gray-600">Tên danh mục</th>
                            <th className="px-6 py-4 text-sm font-semibold text-gray-600">Mô tả</th>
                            <th className="px-6 py-4 text-sm font-semibold text-gray-600 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-50">
                        {loading ? (
                            <tr>
                                <td colSpan="3" className="px-6 py-10 text-center text-gray-400">
                                    <Loader2 className="animate-spin mx-auto mb-2" />
                                    Đang tải dữ liệu...
                                </td>
                            </tr>
                        ) : currentItems.length > 0 ? (
                            currentItems.map((category) => (
                                <tr key={category.id} className="hover:bg-blue-50/30 transition-colors group">
                                    <td className="px-6 py-4">
                                        <span className="font-medium text-gray-700">{category.name}</span>
                                    </td>
                                    <td className="px-6 py-4">
                                        <p className="text-gray-500 text-sm line-clamp-1 italic">
                                            {category.description || "Chưa có mô tả"}
                                        </p>
                                    </td>
                                    <td className="px-6 py-4 text-right">
                                        <div className="flex justify-end gap-2">
                                            {/* ĐƯỜNG DẪN ĐẾN TRANG SỬA (KÈM ID) */}
                                            <Link
                                                to={`/admin/categories/edit/${category.id}`}
                                                className="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                                title="Sửa danh mục"
                                            >
                                                <Pencil size={18} />
                                            </Link>

                                            <button
                                                onClick={() => setDeleteId(category.id)}
                                                className="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Xóa danh mục"
                                            >
                                                <Trash2 size={18} />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="3" className="px-6 py-10 text-center text-gray-400">
                                    Không tìm thấy danh mục nào.
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>

                {/* Pagination (Phần này giữ nguyên như cũ) */}
                <div className="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/30">
                    <span className="text-sm text-gray-500">
                        Hiển thị {indexOfFirstItem + 1} - {Math.min(indexOfLastItem, filteredCategories.length)} trên {filteredCategories.length}
                    </span>
                    <div className="flex gap-2">
                        <button
                            disabled={currentPage === 1}
                            onClick={() => setCurrentPage(prev => prev - 1)}
                            className="p-2 rounded-lg border bg-white hover:bg-gray-50 disabled:opacity-30 transition-all"
                        >
                            <ChevronLeft size={18} />
                        </button>
                        {[...Array(totalPages)].map((_, i) => (
                            <button
                                key={i}
                                onClick={() => setCurrentPage(i + 1)}
                                className={`w-9 h-9 rounded-lg border text-sm font-medium transition-all ${currentPage === i + 1
                                    ? "bg-blue-600 text-white border-blue-600 shadow-sm"
                                    : "bg-white hover:bg-gray-50 text-gray-600"
                                    }`}
                            >
                                {i + 1}
                            </button>
                        ))}
                        <button
                            disabled={currentPage === totalPages}
                            onClick={() => setCurrentPage(prev => prev + 1)}
                            className="p-2 rounded-lg border bg-white hover:bg-gray-50 disabled:opacity-30 transition-all"
                        >
                            <ChevronRight size={18} />
                        </button>
                    </div>
                </div>
            </div>

            {/* Modal Xác nhận Xóa (Giữ nguyên) */}
            {deleteId && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm animate-in fade-in duration-200">
                    <div className="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl animate-in zoom-in-95 duration-200">
                        <div className="flex items-center justify-center w-14 h-14 mx-auto bg-red-50 rounded-full mb-4">
                            <AlertCircle className="text-red-500" size={28} />
                        </div>
                        <h3 className="text-xl font-bold text-center text-gray-800">Xác nhận xóa?</h3>
                        <p className="text-center text-gray-500 mt-2 px-2">
                            Mọi dữ liệu liên quan đến danh mục này sẽ bị ảnh hưởng. Bạn có chắc chắn không?
                        </p>
                        <div className="flex gap-3 mt-8">
                            <button
                                onClick={() => setDeleteId(null)}
                                className="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-xl transition-all"
                            >
                                Quay lại
                            </button>
                            <button
                                onClick={confirmDelete}
                                disabled={isDeleting}
                                className="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all flex items-center justify-center shadow-lg shadow-red-100"
                            >
                                {isDeleting ? <Loader2 className="animate-spin" size={20} /> : "Xóa vĩnh viễn"}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default CategoryList;