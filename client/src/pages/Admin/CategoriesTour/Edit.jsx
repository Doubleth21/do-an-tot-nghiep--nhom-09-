import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { ChevronLeft, RefreshCw, Loader2 } from "lucide-react";
import { getCategory, updateCategory } from "../../../api/categories";
import toast from "react-hot-toast";

const EditCategory = () => {
    const { id } = useParams(); // Lấy ID từ URL
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [fetching, setFetching] = useState(true);
    const [formData, setFormData] = useState({ name: "", description: "" });

    // Lấy dữ liệu danh mục hiện tại
    useEffect(() => {
        const fetchDetail = async () => {
            try {
                const res = await getCategory(id);
                setFormData({
                    name: res.data.name,
                    description: res.data.description
                });
            } catch (error) {
                toast.error("Không tìm thấy dữ liệu danh mục");
                navigate("/admin/categories");
            } finally {
                setFetching(false);
            }
        };
        fetchDetail();
    }, [id, navigate]);

    const handleUpdate = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            await updateCategory(id, formData);
            toast.success("Cập nhật thành công!");
            navigate("/admin/categories");
        } catch (error) {
            toast.error("Lỗi khi cập nhật dữ liệu");
        } finally {
            setLoading(false);
        }
    };

    if (fetching) {
        return (
            <div className="h-96 flex items-center justify-center">
                <Loader2 className="animate-spin text-blue-500" size={40} />
            </div>
        );
    }

    return (
        <div className="max-w-3xl mx-auto">
            <div className="flex items-center gap-4 mb-8">
                <button
                    onClick={() => navigate(-1)}
                    className="p-2 bg-white border border-gray-100 rounded-xl shadow-sm hover:bg-gray-50 text-gray-500 transition-all"
                >
                    <ChevronLeft size={24} />
                </button>
                <div>
                    <h1 className="text-2xl font-bold text-gray-800">Chỉnh sửa danh mục</h1>
                    <p className="text-sm text-gray-500">Cập nhật thông tin cho mã: <span className="font-mono text-blue-600">#{id}</span></p>
                </div>
            </div>

            <div className="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <form onSubmit={handleUpdate} className="space-y-6">
                    <div>
                        <label className="block text-sm font-semibold text-gray-700 mb-2">Tên danh mục</label>
                        <input
                            type="text"
                            className="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                            value={formData.name}
                            onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-semibold text-gray-700 mb-2">Mô tả</label>
                        <textarea
                            rows="6"
                            className="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all resize-none"
                            value={formData.description}
                            onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                        ></textarea>
                    </div>

                    <div className="flex justify-end gap-4 pt-4">
                        <button
                            type="button"
                            onClick={() => navigate("/admin/categories")}
                            className="px-8 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold transition-all"
                        >
                            Hủy
                        </button>
                        <button
                            type="submit"
                            disabled={loading}
                            className="px-8 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-bold shadow-lg shadow-orange-100 transition-all flex items-center gap-2"
                        >
                            {loading ? <Loader2 className="animate-spin" size={20} /> : <><RefreshCw size={20} /> Cập nhật ngay</>}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default EditCategory;