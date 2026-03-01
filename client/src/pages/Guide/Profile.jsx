import React from "react";

const Profile = () => {
  const profile = { name: "Nguyễn Văn A", email: "guide@example.com", phone: "0900 000 000" };

  return (
    <div className="max-w-6xl mx-auto pb-20 p-4 animate-in fade-in duration-500">
      <div className="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <h1 className="text-2xl font-extrabold text-slate-800">Hồ sơ hướng dẫn viên</h1>
        <div className="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <p className="text-sm text-slate-500">Họ và tên</p>
            <p className="font-bold text-slate-800">{profile.name}</p>
          </div>
          <div>
            <p className="text-sm text-slate-500">Email</p>
            <p className="font-bold text-slate-800">{profile.email}</p>
          </div>
          <div>
            <p className="text-sm text-slate-500">Số điện thoại</p>
            <p className="font-bold text-slate-800">{profile.phone}</p>
          </div>
          <div>
            <p className="text-sm text-slate-500">Trạng thái</p>
            <p className="font-bold text-blue-600">Đang hoạt động</p>
          </div>
        </div>

        <div className="mt-6">
          <button className="py-3 px-5 bg-blue-600 text-white rounded-[2.5rem] font-black shadow-lg">Chỉnh sửa hồ sơ</button>
        </div>
      </div>
    </div>
  );
};

export default Profile;
