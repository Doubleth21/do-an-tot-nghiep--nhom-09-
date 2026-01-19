import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { ChevronLeft, Save, Loader2 } from "lucide-react";
import { createCategory } from "../../../api/categories";
import toast from "react-hot-toast";

const AddCategory = () => {
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [formData, setFormData] = useState({ name: "", description: "" });

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!formData.name.trim()) return toast.error("Vui lòng nhập tên danh mục");

        setLoading(true);
        try {
            await createCategory(formData);
            toast.success("Thêm danh mục thành công!");
            navigate("/admin/categories"); // Quay lại danh sách
        } catch (error) {
            toast.error("Lỗi khi thêm danh mục");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-3xl mx-auto">
            {/* Header & Back Button */}
            <div className="flex items-center gap-4 mb-8">
                <button
                    onClick={() => navigate(-1)}
                    className="p-2 bg-white border border-gray-100 rounded-xl shadow-sm hover:bg-gray-50 text-gray-500 transition-all"
                >
                    <ChevronLeft size={24} />
                </button>
                <div>
                    <h1 className="text-2xl font-bold text-gray-800">Thêm danh mục mới</h1>
                    <p className="text-sm text-gray-500">Tạo loại hình tour du lịch mới cho hệ thống</p>
                </div>
            </div>

            {/* Form Card */}
            <div className="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid grid-cols-1 gap-6">
                        <div>
                            <label className="block text-sm font-semibold text-gray-700 mb-2">
                                Tên danh mục <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                placeholder="Ví dụ: Tour Nghỉ Dưỡng Cao Cấp"
                                className="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                                value={formData.name}
                                onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-semibold text-gray-700 mb-2">
                                Mô tả chi tiết
                            </label>
                            <textarea
                                rows="6"
                                placeholder="Viết mô tả về danh mục này..."
                                className="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all resize-none"
                                value={formData.description}
                                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                            ></textarea>
                        </div>
                    </div>

                    <div className="flex justify-end gap-4 pt-4">
                        <button
                            type="button"
                            onClick={() => navigate("/admin/categories")}
                            className="px-8 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold transition-all"
                        >
                            Hủy bỏ
                        </button>
                        <button
                            type="submit"
                            disabled={loading}
                            className="px-8 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg shadow-blue-100 transition-all flex items-center gap-2"
                        >
                            {loading ? <Loader2 className="animate-spin" size={20} /> : <><Save size={20} /> Lưu danh mục</>}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default AddCategory;