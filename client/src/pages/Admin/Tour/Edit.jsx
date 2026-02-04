import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import {
    ChevronLeft, Save, Upload, Loader2, X,
    Image as ImageIcon, DollarSign, Tag, Building2, ClipboardList
} from "lucide-react";
import { useImageUpload } from "../../../hooks/useImageUpload";
import { getTour, updateTour } from "../../../api/tour";
import { getCategories } from "../../../api/categories";
import toast, { Toaster } from "react-hot-toast";

const EditTour = () => {
    const { id } = useParams(); // Lấy ID tour từ URL
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [fetching, setFetching] = useState(true);
    const [categories, setCategories] = useState([]);

    const { previews, setPreviews, handleImagesChange, removeImage } = useImageUpload();

    const [formData, setFormData] = useState({
        name: "",
        category_id: "",
        supplier: "",
        price: "",
        status: "active",
        description: "",
        policy: ""
    });

    // 1. Load dữ liệu ban đầu
    useEffect(() => {
        const initData = async () => {
            try {
                setFetching(true);
                const [tourRes, catRes] = await Promise.all([
                    getTour(id),
                    getCategories()
                ]);

                const tour = tourRes.data;
                setCategories(catRes.data || []);

                // Đổ dữ liệu vào form
                setFormData({
                    name: tour.name || "",
                    category_id: tour.category_id || "",
                    supplier: tour.supplier || "",
                    price: tour.price || "",
                    status: tour.status || "active",
                    description: tour.description || "",
                    policy: tour.policy || ""
                });

                // Đổ ảnh cũ vào preview
                if (tour.images) {
                    setPreviews(tour.images);
                }
            } catch (err) {
                toast.error("Không thể tải thông tin tour");
                navigate("/admin/tours");
            } finally {
                setFetching(false);
            }
        };
        initData();
    }, [id]);

    // 2. Xử lý cập nhật
    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        try {
            const dataToUpdate = {
                ...formData,
                price: Number(formData.price),
                images: previews // Lưu mảng ảnh hiện tại (bao gồm cả cũ và mới)
            };

            await updateTour(id, dataToUpdate);
            toast.success("Cập nhật thông tin thành công!");
            setTimeout(() => navigate("/admin/tours"), 1000);
        } catch (error) {
            toast.error("Lỗi khi cập nhật dữ liệu");
        } finally {
            setLoading(false);
        }
    };

    if (fetching) {
        return (
            <div className="h-96 flex flex-col items-center justify-center text-slate-400">
                <Loader2 className="animate-spin mb-4" size={40} />
                <p className="font-medium">Đang tải dữ liệu tour...</p>
            </div>
        );
    }

    return (
        <div className="max-w-6xl mx-auto pb-20 p-4 animate-in fade-in duration-500">
            <Toaster position="top-right" />

            <div className="flex items-center gap-4 mb-8">
                <button onClick={() => navigate(-1)} className="p-3 bg-white rounded-2xl border shadow-sm hover:bg-gray-50 text-gray-500 transition-all">
                    <ChevronLeft size={24} />
                </button>
                <div>
                    <h1 className="text-2xl font-black text-slate-800">Chỉnh sửa Tour</h1>
                    <p className="text-sm text-slate-500 font-medium">ID Tour: #{id}</p>
                </div>
            </div>

            <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {/* CỘT TRÁI: THÔNG TIN VĂN BẢN (Giống trang Add) */}
                <div className="lg:col-span-2 space-y-6">
                    <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">Tên Tour *</label>
                            <input type="text" required className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 outline-none transition-all font-medium"
                                value={formData.name} onChange={e => setFormData({ ...formData, name: e.target.value })} />
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2">Danh mục *</label>
                                <select className="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white outline-none font-medium"
                                    value={formData.category_id} onChange={e => setFormData({ ...formData, category_id: e.target.value })}>
                                    <option value="">Chọn loại tour...</option>
                                    {categories.map(cat => <option key={cat.id} value={cat.id}>{cat.name}</option>)}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2">Nhà cung cấp</label>
                                <input type="text" className="w-full px-5 py-4 rounded-2xl border border-slate-200 outline-none font-medium"
                                    value={formData.supplier} onChange={e => setFormData({ ...formData, supplier: e.target.value })} />
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">Mô tả</label>
                            <textarea rows="5" className="w-full px-5 py-4 rounded-2xl border border-slate-200 outline-none font-medium resize-none"
                                value={formData.description} onChange={e => setFormData({ ...formData, description: e.target.value })} />
                        </div>
                    </div>

                    {/* BỘ SƯU TẬP ẢNH */}
                    <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <label className="block text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <ImageIcon size={18} className="text-blue-500" /> Thư viện hình ảnh
                        </label>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div className="relative h-32 rounded-3xl border-2 border-dashed border-slate-200 hover:border-blue-400 hover:bg-blue-50 transition-all flex flex-col items-center justify-center group cursor-pointer">
                                <Upload className="text-slate-400 group-hover:text-blue-500 mb-1" size={24} />
                                <span className="text-[10px] font-bold text-slate-500 uppercase">Thêm ảnh</span>
                                <input type="file" multiple accept="image/*" onChange={handleImagesChange} className="absolute inset-0 opacity-0 cursor-pointer" />
                            </div>

                            {previews.map((src, index) => (
                                <div key={index} className="relative h-32 rounded-3xl overflow-hidden group border border-slate-100 shadow-sm">
                                    <img src={src} className="w-full h-full object-cover" alt="preview" />
                                    <button type="button" onClick={() => removeImage(index)} className="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-xl opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                                        <X size={14} strokeWidth={3} />
                                    </button>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* CỘT PHẢI: GIÁ & TRẠNG THÁI */}
                <div className="space-y-6">
                    <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-1">
                                <DollarSign size={16} /> Giá tour
                            </label>
                            <input type="number" required className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 outline-none font-black text-blue-600 text-2xl"
                                value={formData.price} onChange={e => setFormData({ ...formData, price: e.target.value })} />
                        </div>

                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-3">Trạng thái</label>
                            <div className="space-y-2">
                                {['active', 'draft', 'hidden'].map(status => (
                                    <label key={status} className={`flex items-center justify-between p-4 rounded-2xl border cursor-pointer transition-all ${formData.status === status ? 'border-blue-500 bg-blue-50/50' : 'border-slate-50'}`}>
                                        <span className="capitalize text-sm font-bold text-slate-600">{status}</span>
                                        <input type="radio" name="status" checked={formData.status === status} onChange={() => setFormData({ ...formData, status: status })} className="accent-blue-600 w-4 h-4" />
                                    </label>
                                ))}
                            </div>
                        </div>
                    </div>

                    <button type="submit" disabled={loading} className="w-full py-5 bg-blue-600 hover:bg-blue-700 text-white font-black text-lg rounded-[2.5rem] shadow-xl transition-all flex items-center justify-center gap-3">
                        {loading ? <Loader2 className="animate-spin" /> : <><Save size={24} /> Cập nhật Tour</>}
                    </button>
                </div>
            </form>
        </div>
    );
};

export default EditTour;