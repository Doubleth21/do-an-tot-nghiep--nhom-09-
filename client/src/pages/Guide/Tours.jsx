import React from "react";

const Tours = () => {
  // Giả sử guide hiện tại có id = 1. Sau khi tích hợp auth, lấy từ context/auth
  const currentGuideId = 1;

  const tours = [
    { id: 1, name: "Huế City Tour", date: "2026-02-20", seats: 12, guides: [1, 2] },
    { id: 2, name: "Đà Nẵng Beaches", date: "2026-03-01", seats: 8, guides: [2] },
  ];

  // Lọc chỉ những tour mà guide được phân công / có mặt trong mảng guides
  const myTours = tours.filter((t) => Array.isArray(t.guides) && t.guides.includes(currentGuideId));

  return (
    <div className="max-w-6xl mx-auto pb-20 p-4 animate-in fade-in duration-500">
      <div className="flex items-center justify-between mb-6">
        <div>
          <h1 className="text-2xl font-extrabold text-slate-800">Quản lý Tour</h1>
          <p className="text-sm text-slate-500">Danh sách tour mà bạn phụ trách</p>
        </div>
      </div>

      <div className="bg-white p-6 rounded-[2.5rem] border border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-4">
        {myTours.length === 0 ? (
          <div className="p-6 rounded-[1.5rem] border border-slate-100 shadow-sm text-slate-500">Bạn hiện chưa được book tour nào.</div>
        ) : (
          myTours.map((t) => (
            <div key={t.id} className="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm">
              <h3 className="text-lg font-bold text-slate-800">{t.name}</h3>
              <p className="text-sm text-slate-500">Ngày: {t.date} • Chỗ trống: {t.seats}</p>
              <div className="mt-4 flex gap-2">
                <button className="py-2 px-4 bg-white border rounded-2xl">Chi tiết</button>
              </div>
            </div>
          ))
        )}
      </div>
    </div>
  );
};

export default Tours;
