import React, { useState } from "react";
import {
    User, Shield, Briefcase, Save, ArrowLeft,
    Mail, Lock, Phone, Award, BookOpen, Sparkles
} from "lucide-react";
import { useNavigate } from "react-router-dom";
import { createUser } from "../../../api/user";
import toast, { Toaster } from "react-hot-toast";

const AddUser = () => {
    const navigate = useNavigate();
    const [role, setRole] = useState("admin");
    const [loading, setLoading] = useState(false);

    const [formData, setFormData] = useState({
        username: "",
        fullname: "",
        email: "",
        password: "",
        phone: "",
        status: 1,

        // Guide fields
        cccd: "",
        language: "",
        certificate: "",
        experience: "",
        specialization: ""
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            await createUser({ ...formData, role });
            toast.success("Tạo tài khoản thành công!", {
                duration: 3000,
                style: {
                    borderRadius: "12px",
                    background: "#1e293b",
                    color: "#fff"
                }
            });
            setTimeout(() => navigate("/admin/users"), 1500);
        } catch (error) {
            toast.error("Lỗi: Tên đăng nhập hoặc Email đã tồn tại");
        } finally {
            setLoading(false);
        }
    };

    const inputClass =
        "w-full p-3.5 rounded-xl border border-slate-200 bg-white outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-700 font-medium placeholder:text-slate-400 placeholder:font-normal";

    const labelClass =
        "text-[13px] font-bold text-slate-500 mb-1.5 ml-1 flex items-center gap-2";

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
                        CẤP TÀI KHOẢN
                    </h1>
                    <p className="text-slate-400 font-medium text-sm">
                        Thiết lập quyền truy cập hệ thống nội bộ
                    </p>
                </div>
            </div>

            <form
                onSubmit={handleSubmit}
                className="grid grid-cols-1 lg:grid-cols-3 gap-8"
            >
                {/* LEFT COLUMN */}
                <div className="lg:col-span-2 space-y-6">
                    {/* BASIC INFO */}
                    <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                        <h2 className="text-lg font-black text-slate-800 mb-6 flex items-center gap-3">
                            <div className="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <User size={20} />
                            </div>
                            Thông tin cơ bản
                        </h2>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div className="space-y-1">
                                <label className={labelClass}>
                                    <Mail size={14} /> Tên đăng nhập *
                                </label>
                                <input
                                    type="text"
                                    required
                                    className={inputClass}
                                    placeholder="nva_guide"
                                    onChange={(e) =>
                                        setFormData({
                                            ...formData,
                                            username: e.target.value
                                        })
                                    }
                                />
                            </div>

                            <div className="space-y-1">
                                <label className={labelClass}>
                                    <Mail size={14} /> Email *
                                </label>
                                <input
                                    type="email"
                                    required
                                    className={inputClass}
                                    placeholder="example@email.com"
                                    onChange={(e) =>
                                        setFormData({
                                            ...formData,
                                            email: e.target.value
                                        })
                                    }
                                />
                            </div>

                            <div className="space-y-1">
                                <label className={labelClass}>
                                    <Lock size={14} /> Mật khẩu *
                                </label>
                                <input
                                    type="password"
                                    required
                                    className={inputClass}
                                    placeholder="••••••••"
                                    onChange={(e) =>
                                        setFormData({
                                            ...formData,
                                            password: e.target.value
                                        })
                                    }
                                />
                            </div>

                            <div className="space-y-1">
                                <label className={labelClass}>
                                    <Sparkles size={14} /> Họ và tên *
                                </label>
                                <input
                                    type="text"
                                    required
                                    className={inputClass}
                                    placeholder="Nguyễn Văn A"
                                    onChange={(e) =>
                                        setFormData({
                                            ...formData,
                                            fullname: e.target.value
                                        })
                                    }
                                />
                            </div>

                            <div className="space-y-1">
                                <label className={labelClass}>
                                    <Phone size={14} /> Số điện thoại
                                </label>
                                <input
                                    type="text"
                                    className={inputClass}
                                    placeholder="0908xxxxxx"
                                    onChange={(e) =>
                                        setFormData({
                                            ...formData,
                                            phone: e.target.value
                                        })
                                    }
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
                                    <label className={labelClass}>
                                        <Shield size={14} /> Số CCCD
                                    </label>
                                    <input
                                        type="text"
                                        className={inputClass}
                                        placeholder="12 số CCCD"
                                        onChange={(e) =>
                                            setFormData({
                                                ...formData,
                                                cccd: e.target.value
                                            })
                                        }
                                    />
                                </div>

                                <div className="space-y-1">
                                    <label className={labelClass}>
                                        <BookOpen size={14} /> Ngôn ngữ
                                    </label>
                                    <input
                                        type="text"
                                        className={inputClass}
                                        placeholder="Anh, Nhật, Hàn..."
                                        onChange={(e) =>
                                            setFormData({
                                                ...formData,
                                                language: e.target.value
                                            })
                                        }
                                    />
                                </div>

                                <div className="space-y-1">
                                    <label className={labelClass}>
                                        <Award size={14} /> Chuyên môn hóa
                                    </label>
                                    <input
                                        type="text"
                                        className={inputClass}
                                        placeholder="Tour văn hóa, Leo núi..."
                                        onChange={(e) =>
                                            setFormData({
                                                ...formData,
                                                specialization: e.target.value
                                            })
                                        }
                                    />
                                </div>

                                <div className="md:col-span-2 space-y-1">
                                    <label className={labelClass}>
                                        Chứng chỉ / Bằng cấp
                                    </label>
                                    <input
                                        type="text"
                                        className={inputClass}
                                        placeholder="Thẻ HDV, Chứng chỉ cứu hộ..."
                                        onChange={(e) =>
                                            setFormData({
                                                ...formData,
                                                certificate: e.target.value
                                            })
                                        }
                                    />
                                </div>

                                <div className="md:col-span-2 space-y-1">
                                    <label className={labelClass}>
                                        Kinh nghiệm chi tiết
                                    </label>
                                    <textarea
                                        rows="4"
                                        className={`${inputClass} resize-none`}
                                        placeholder="Mô tả kinh nghiệm làm việc..."
                                        onChange={(e) =>
                                            setFormData({
                                                ...formData,
                                                experience: e.target.value
                                            })
                                        }
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
                                Phân quyền
                            </label>
                            <div className="flex flex-col gap-2 mt-3">
                                {["admin", "guide"].map((r) => (
                                    <button
                                        key={r}
                                        type="button"
                                        onClick={() => setRole(r)}
                                        className={`p-4 rounded-2xl border-2 flex items-center justify-between transition-all ${role === r
                                            ? "border-blue-600 bg-blue-50/50"
                                            : "border-slate-100 bg-slate-50 opacity-60"
                                            }`}
                                    >
                                        <span
                                            className={`font-bold ${role === r
                                                ? "text-blue-700"
                                                : "text-slate-500"
                                                }`}
                                        >
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
                            {loading ? "ĐANG XỬ LÝ..." : (
                                <>
                                    LƯU TÀI KHOẢN
                                    <Save size={22} />
                                </>
                            )}
                        </button>

                        <p className="text-[11px] text-center text-slate-400 font-medium uppercase">
                            Kiểm tra thông tin trước khi lưu
                        </p>
                    </div>
                </div>
            </form>
        </div>
    );
};

export default AddUser;
