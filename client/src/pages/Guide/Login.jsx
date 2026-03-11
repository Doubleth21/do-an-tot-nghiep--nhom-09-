import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { login as apiLogin } from "../../api/user";

const Login = () => {
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      setError("");
      // gọi API đăng nhập
      const { data } = await apiLogin({
        email: email,
        password,
      });

      // lưu token và user vào localStorage/hoặc state quản lý
      if (data.token) {
        localStorage.setItem("auth_token", data.token);
        localStorage.setItem("auth_user", JSON.stringify(data.user));
      }

      // điều hướng theo backend trả về hoặc mặc định
      const redirect = data.redirect || "/guide";
      navigate(redirect);
    } catch (err) {
      console.error(err);
      const msg = err.response?.data?.message || "Đã có lỗi xảy ra";
      setError(msg);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-slate-50">
      <div className="bg-white rounded-[2.5rem] max-w-md w-full p-8 shadow-2xl">
        <h2 className="text-2xl font-black text-slate-800 mb-2">Đăng nhập</h2>
        <p className="text-sm text-slate-500 mb-6">Đăng nhập bằng tài khoản hướng dẫn viên</p>

        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block text-sm font-bold text-slate-700 mb-2">Email</label>
            <input
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
              className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-medium"
            />
          </div>

          <div>
            <label className="block text-sm font-bold text-slate-700 mb-2">Mật khẩu</label>
            <input
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              className="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-medium"
            />
          </div>

          {error && <div className="text-rose-600 font-medium">{error}</div>}

          <button type="submit" className="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black text-lg rounded-[2.5rem] shadow-xl transition-all">
            Đăng nhập
          </button>
        </form>

        <p className="text-center text-xs text-slate-400 mt-4">Quên mật khẩu? Liên hệ quản trị viên.</p>
      </div>
    </div>
  );
};

export default Login;