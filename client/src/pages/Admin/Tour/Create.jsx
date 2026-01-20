import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import {
    ChevronLeft, Save, Upload, Loader2, X,
    Image as ImageIcon, DollarSign, Tag, Building2, ClipboardList
} from "lucide-react";
import { useImageUpload } from "../../../hooks/useImageUpload";
import { createTour } from "../../../api/tour";
import { getCategories } from "../../../api/categories";
import toast, { Toaster } from "react-hot-toast";

const AddTour = () => {
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [categories, setCategories] = useState([]);

    // Sử dụng hook xử lý ảnh
    const { images, previews, handleImagesChange, removeImage } = useImageUpload();

    const [formData, setFormData] = useState({
        name: "",
        category_id: "",
        supplier: "",
        price: "",
        status: "active",
        description: "",
        policy: ""
    });

    // Lấy danh mục để đổ vào Select box
    useEffect(() => {
        const fetchCats = async () => {
            try {
                const res = await getCategories();
                setCategories(res.data || []);
            } catch (err) { toast.error("Không thể tải danh mục"); }
        };
        fetchCats();
    }, []);

    // HÀM XỬ LÝ LƯU DỮ LIỆU (ĐÃ SỬA)
    const handleSubmit = async (e) => {
        e.preventDefault();

        // Kiểm tra các trường bắt buộc
        if (!formData.name || !formData.category_id || !formData.price) {
            return toast.error("Vui lòng nhập Tên, Danh mục và Giá tour!");
        }

        setLoading(true);

        try {
            /** * VỚI JSON-SERVER (Giai đoạn Frontend):
             * Gửi một Object thông thường, không dùng FormData.
             * Lưu mảng previews (string) thay vì mảng file.
             */
            const dataToSave = {
                ...formData,
                price: Number(formData.price), // Chuyển giá sang kiểu số
                images: previews // Lưu các link ảnh tạm thời
            };

            // Gọi API
            await createTour(dataToSave);

            toast.success("Đã thêm tour mới vào hệ thống!");

            // Chờ một chút rồi quay lại danh sách
            setTimeout(() => navigate("/admin/tours"), 1500);

        } catch (error) {
            console.error("Lỗi khi lưu:", error);
            toast.error("Có lỗi xảy ra khi lưu vào db.json");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-6xl mx-auto pb-20 p-4 animate-in fade-in duration-500">
            <Toaster position="top-right" />

            {/* Nút quay lại và Tiêu đề */}
            <div className="flex items-center gap-4 mb-8">
                <button
                    onClick={() => navigate(-1)}
                    className="p-3 bg-white rounded-2xl border shadow-sm hover:bg-gray-50 text-gray-500 transition-all"
                >
                    <ChevronLeft size={24} />
                </button>
                <div>
                    <h1 className="text-2xl font-black text-slate-800 tracking-tight">Tạo Tour Mới</h1>
                    <p className="text-sm text-slate-500 font-medium">Thiết lập thông tin và bộ sưu tập ảnh cho tour</p>
                </div>
            </div>

            <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {/* CỘT TRÁI: THÔNG TIN VĂN BẢN */}
                <div className="lg:col-span-2 space-y-6">
                    <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                        <div className="flex items-center gap-2 text-blue-600 mb-2">
                            <ClipboardList size={20} />
                            <h2 className="text-xs font-bold uppercase tracking-widest">Thông tin chi tiết</h2>
                        </div>

                        {/* Tên Tour */}
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">Tên Tour <span className="text-red-500">*</span></label>
                            <input
                                type="text"
                                placeholder="Ví dụ: Tour Đà Nẵng - Hội An 4 ngày 3 đêm"
                                className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-medium"
                                value={formData.name}
                                onChange={e => setFormData({ ...formData, name: e.target.value })}
                            />
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Danh mục */}
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-1"><Tag size={16} /> Danh mục *</label>
                                <select
                                    className="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white focus:border-blue-500 outline-none transition-all font-medium appearance-none"
                                    value={formData.category_id}
                                    onChange={e => setFormData({ ...formData, category_id: e.target.value })}
                                >
                                    <option value="">Chọn loại tour...</option>
                                    {categories.map(cat => (
                                        <option key={cat.id} value={cat.id}>{cat.name}</option>
                                    ))}
                                </select>
                            </div>
                            {/* Nhà cung cấp */}
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-1"><Building2 size={16} /> Nhà cung cấp</label>
                                <input
                                    type="text"
                                    placeholder="Tên đối tác..."
                                    className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 outline-none transition-all font-medium"
                                    value={formData.supplier}
                                    onChange={e => setFormData({ ...formData, supplier: e.target.value })}
                                />
                            </div>
                        </div>

                        {/* Mô tả */}
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2">Mô tả hành trình</label>
                            <textarea
                                rows="5"
                                placeholder="Mô tả tóm tắt về tour này..."
                                className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 outline-none transition-all font-medium resize-none"
                                value={formData.description}
                                onChange={e => setFormData({ ...formData, description: e.target.value })}
                            />
                        </div>

                        {/* Chính sách */}
                        <div>
                            <label className="block text-sm font-bold text-rose-600 mb-2">Chính sách & Lưu ý</label>
                            <textarea
                                rows="4"
                                placeholder="Thông tin hoàn hủy, trẻ em, dịch vụ bao gồm..."
                                className="w-full px-5 py-4 rounded-2xl border border-rose-100 bg-rose-50/20 focus:border-rose-300 outline-none transition-all font-medium resize-none text-slate-600"
                                value={formData.policy}
                                onChange={e => setFormData({ ...formData, policy: e.target.value })}
                            />
                        </div>
                    </div>

                    {/* BỘ SƯU TẬP ẢNH */}
                    <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <label className="block text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <ImageIcon size={18} className="text-blue-500" /> Thư viện hình ảnh
                        </label>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                            {/* Nút Upload */}
                            <div className="relative h-32 rounded-3xl border-2 border-dashed border-slate-200 hover:border-blue-400 hover:bg-blue-50 transition-all flex flex-col items-center justify-center group cursor-pointer">
                                <Upload className="text-slate-400 group-hover:text-blue-500 mb-1" size={24} />
                                <span className="text-[10px] font-bold text-slate-500 uppercase">Thêm ảnh</span>
                                <input
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    onChange={handleImagesChange}
                                    className="absolute inset-0 opacity-0 cursor-pointer"
                                />
                            </div>

                            {/* Previews */}
                            {previews.map((src, index) => (
                                <div key={index} className="relative h-32 rounded-3xl overflow-hidden group border border-slate-100 shadow-sm">
                                    <img src={src} className="w-full h-full object-cover" alt="tour preview" />
                                    <button
                                        type="button"
                                        onClick={() => removeImage(index)}
                                        className="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-xl opacity-0 group-hover:opacity-100 transition-all shadow-lg"
                                    >
                                        <X size={14} strokeWidth={3} />
                                    </button>
                                    {index === 0 && (
                                        <span className="absolute bottom-2 left-2 bg-blue-600 text-white text-[8px] font-black px-2 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                                            Ảnh bìa
                                        </span>
                                    )}
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* CỘT PHẢI: GIÁ, TRẠNG THÁI & SUBMIT */}
                <div className="space-y-6">
                    <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
                        {/* Giá tiền */}
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-1">
                                Giá tour niêm yết
                            </label>
                            <input
                                type="number"
                                required
                                placeholder="0"
                                className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 outline-none transition-all font-black text-blue-600 text-2xl"
                                value={formData.price}
                                onChange={e => setFormData({ ...formData, price: e.target.value })}
                            />
                        </div>

                        {/* Trạng thái */}
                        <div>
                            <label className="block text-sm font-bold text-slate-700 mb-3 tracking-wide">Trạng thái công bố</label>
                            <div className="space-y-2">
                                {['active', 'draft', 'hidden'].map(status => (
                                    <label key={status} className={`flex items-center justify-between p-4 rounded-2xl border cursor-pointer transition-all ${formData.status === status ? 'border-blue-500 bg-blue-50/50 ring-2 ring-blue-500/5' : 'border-slate-50 hover:bg-slate-50'}`}>
                                        <span className="capitalize text-sm font-bold text-slate-600">
                                            {status === 'active' ? 'Đang bán' : status === 'draft' ? 'Bản nháp' : 'Tạm ẩn'}
                                        </span>
                                        <input
                                            type="radio"
                                            name="status"
                                            checked={formData.status === status}
                                            onChange={() => setFormData({ ...formData, status: status })}
                                            className="accent-blue-600 w-4 h-4"
                                        />
                                    </label>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* Nút lưu */}
                    <button
                        type="submit"
                        disabled={loading}
                        className="w-full py-5 bg-blue-600 hover:bg-blue-700 text-white font-black text-lg rounded-[2.5rem] shadow-xl shadow-blue-200 transition-all flex items-center justify-center gap-3 disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        {loading ? <Loader2 className="animate-spin" /> : <><Save size={24} strokeWidth={2.5} /> Lưu & Công bố</>}
                    </button>

                    <p className="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest px-4">
                        Dữ liệu sẽ được lưu vào hệ thống nội bộ ngay lập tức
                    </p>
                </div>
            </form>
        </div>
    );
};

export default AddTour;