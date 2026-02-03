import React, { useEffect, useState } from "react";
import {
    User, Shield, Briefcase, Save, ArrowLeft,
    Mail, Lock, Phone, Award, BookOpen, Sparkles, CheckCircle2
} from "lucide-react";
import { useNavigate, useParams } from "react-router-dom";
import toast, { Toaster } from "react-hot-toast";

// API
import { getUserById, updateUser } from "../../../api/user";

const EditUser = () => {
    const navigate = useNavigate();
    const { id } = useParams();

    const [role, setRole] = useState("admin");
    const [loading, setLoading] = useState(false);
    const [fetching, setFetching] = useState(true);

    const [formData, setFormData] = useState({
        username: "",
        fullname: "",
        email: "",
        password: "", // Để trống nếu không đổi
        phone: "",
        status: 1,
        cccd: "",
        language: "",
        certificate: "",
        experience: "",
        specialization: ""
    });

    /* ================= LOAD USER DATA ================= */
    useEffect(() => {
        const fetchUser = async () => {
            try {
                const res = await getUserById(id);
                const user = res.data;

                setRole(user.role);
                setFormData({
                    username: user.username || "",
                    fullname: user.fullname || "",
                    email: user.email || "",
                    password: "", // Reset mật khẩu về rỗng
                    phone: user.phone || "",
                    status: user.status ?? 1,
                    cccd: user.cccd || "",
                    language: user.language || "",
                    certificate: user.certificate || "",
                    experience: user.experience || "",
                    specialization: user.specialization || ""
                });
            } catch (err) {
                toast.error("Không tìm thấy dữ liệu người dùng");
                navigate("/admin/users");
            } finally {
                setFetching(false);
            }
        };

        fetchUser();
    }, [id, navigate]);

    /* ================= SUBMIT ================= */
    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        try {
            const payload = { ...formData, role };

            // Xử lý mật khẩu: nếu rỗng thì không gửi lên server
            if (!payload.password) {
                delete payload.password;
            }

            await updateUser(id, payload);

            toast.success("Cập nhật tài khoản thành công!", {
                style: { borderRadius: "12px", background: "#1e293b", color: "#fff" }
            });

            setTimeout(() => navigate("/admin/users"), 1200);
        } catch (error) {
            toast.error("Lỗi: Cập nhật thất bại hoặc Email đã tồn tại");
        } finally {
            setLoading(false);
        }
    };

    const inputClass =
        "w-full p-3.5 rounded-xl border border-slate-200 bg-white outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-700 font-medium placeholder:text-slate-400";

    const labelClass =
        "text-[13px] font-bold text-slate-500 mb-1.5 ml-1 flex items-center gap-2";

    if (fetching) {
        return (
            <div className="flex flex-col items-center justify-center p-20 text-slate-500 font-bold uppercase tracking-widest animate-pulse">
                <div className="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-4"></div>
                Đang tải dữ liệu...
            </div>
        );
    }

    return (
        <div className="max-w-5xl mx-auto p-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
            <Toaster position="top-right" />

            {/* TOP BAR */}
            <div className="flex items-center justify-between mb-8">
                <button
                    onClick={() => navigate("/admin/users")}
                    className="group flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors font-semibold"
                >
                    <div className="p-2 rounded-full group-hover:bg-blue-50 transition-all">
                        <ArrowLeft size={20} />
                    </div>
                    Quay lại danh sách
                </button>

                <div className="text-right">
                    <h1 className="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3 justify-end">
                        <Sparkles className="text-blue-500" />
                        CHỈNH SỬA TÀI KHOẢN
                    </h1>
                    <p className="text-slate-400 font-medium text-sm">
                        Cập nhật thông tin và quyền hạn người dùng
                    </p>
                </div>
            </div>

            <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {/* LEFT COLUMN */}
                <div className="lg:col-span-2 space-y-6">
                    {/* BASIC INFO */}
                    <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                        <h2 className="text-lg font-black text-slate-800 mb-6 flex items-center gap-3">
                            <div className="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <User size={20} />
                            </div>
                            Thông tin cá nhân
                        </h2>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div className="space-y-1">
                                <label className={labelClass}><User size={14} /> Username</label>
                                <input disabled className={`${inputClass} bg-slate-50 text-slate-400 cursor-not-allowed`} value={formData.username} />
                            </div>

                            <div className="space-y-1">
                                <label className={labelClass}><Mail size={14} /> Email *</label>
                                <input
                                    type="email"
                                    required
                                    className={inputClass}
                                    value={formData.email}
                                    onChange={e => setFormData({ ...formData, email: e.target.value })}
                                />
                            </div>

                            <div className="space-y-1">
                                <label className={labelClass}><Lock size={14} /> Mật khẩu mới</label>
                                <input
                                    type="password"
                                    className={inputClass}
                                    placeholder="Bỏ trống nếu không đổi"
                                    onChange={e => setFormData({ ...formData, password: e.target.value })}
                                />
                            </div>

                            <div className="space-y-1">
                                <label className={labelClass}><Sparkles size={14} /> Họ và tên *</label>
                                <input
                                    type="text"
                                    required
                                    className={inputClass}
                                    value={formData.fullname}
                                    onChange={e => setFormData({ ...formData, fullname: e.target.value })}
                                />
                            </div>

                            <div className="space-y-1 md:col-span-2">
                                <label className={labelClass}><Phone size={14} /> Số điện thoại</label>
                                <input
                                    type="text"
                                    className={inputClass}
                                    value={formData.phone}
                                    onChange={e => setFormData({ ...formData, phone: e.target.value })}
                                />
                            </div>
                        </div>
                    </div>

                    {/* GUIDE INFO */}
                    {role === "guide" && (
                        <div className="bg-slate-50 p-8 rounded-[2.5rem] border border-blue-100 shadow-inner space-y-6 animate-in zoom-in-95 duration-500">
                            <h2 className="text-lg font-black text-blue-700 flex items-center gap-3">
                                <div className="p-2 bg-blue-600 text-white rounded-lg">
                                    <Briefcase size={20} />
                                </div>
                                Hồ sơ năng lực Guide
                            </h2>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div className="space-y-1">
                                    <label className={labelClass}><Shield size={14} /> Số CCCD</label>
                                    <input
                                        type="text"
                                        className={inputClass}
                                        value={formData.cccd}
                                        onChange={e => setFormData({ ...formData, cccd: e.target.value })}
                                    />
                                </div>

                                <div className="space-y-1">
                                    <label className={labelClass}><BookOpen size={14} /> Ngôn ngữ</label>
                                    <input
                                        type="text"
                                        className={inputClass}
                                        value={formData.language}
                                        onChange={e => setFormData({ ...formData, language: e.target.value })}
                                    />
                                </div>

                                <div className="md:col-span-2 space-y-1">
                                    <label className={labelClass}><Award size={14} /> Chuyên môn / Chứng chỉ</label>
                                    <input
                                        type="text"
                                        className={inputClass}
                                        value={formData.specialization}
                                        onChange={e => setFormData({ ...formData, specialization: e.target.value })}
                                    />
                                </div>

                                <div className="md:col-span-2 space-y-1">
                                    <label className={labelClass}>Kinh nghiệm chi tiết</label>
                                    <textarea
                                        rows="4"
                                        className={`${inputClass} resize-none`}
                                        value={formData.experience}
                                        onChange={e => setFormData({ ...formData, experience: e.target.value })}
                                    />
                                </div>
                            </div>
                        </div>
                    )}
                </div>

                {/* RIGHT COLUMN */}
                <div className="space-y-6">
                    <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 space-y-6">
                        <div>
                            <label className="text-sm font-black text-slate-800 uppercase tracking-widest">
                                Vai trò hiện tại
                            </label>
                            <div className="flex flex-col gap-2 mt-3">
                                {["admin", "guide"].map((r) => (
                                    <button
                                        key={r}
                                        type="button"
                                        onClick={() => setRole(r)}
                                        className={`p-4 rounded-2xl border-2 flex items-center justify-between transition-all ${role === r
                                            ? "border-blue-600 bg-blue-50/50 shadow-md"
                                            : "border-slate-100 bg-slate-50 opacity-60"
                                            }`}
                                    >
                                        <span className={`font-bold ${role === r ? "text-blue-700" : "text-slate-500"}`}>
                                            {r.toUpperCase()}
                                        </span>
                                        {role === r && (
                                            <div className="w-3 h-3 bg-blue-600 rounded-full shadow-[0_0_10px_rgba(37,99,235,0.5)]" />
                                        )}
                                    </button>
                                ))}
                            </div>
                        </div>

                        <button
                            type="submit"
                            disabled={loading}
                            className="w-full py-5 bg-slate-900 hover:bg-blue-600 text-white font-black text-lg rounded-2xl shadow-xl transition-all flex items-center justify-center gap-3 disabled:opacity-50"
                        >
                            {loading ? "ĐANG LƯU..." : (
                                <>
                                    CẬP NHẬT
                                    <Save size={22} />
                                </>
                            )}
                        </button>

                        <p className="text-[11px] text-center text-slate-400 font-medium uppercase">
                            ID Người dùng: {id}
                        </p>
                    </div>
                </div>
            </form>
        </div>
    );
};

export default EditUser;