import React from "react";

const Bookings = () => {
  const bookings = [
    { id: 12345, customer: "Trần Văn B", date: "2026-02-20", status: "Chờ xác nhận" },
    { id: 12346, customer: "Lê Thị C", date: "2026-02-22", status: "Xác nhận" },
  ];

  return (
    <div className="max-w-6xl mx-auto pb-20 p-4 animate-in fade-in duration-500">
      <div className="flex items-center justify-between mb-6">
        <div>
          <h1 className="text-2xl font-extrabold text-slate-800">Đặt chỗ</h1>
          <p className="text-sm text-slate-500">Danh sách đặt chỗ của bạn</p>
        </div>
      </div>

      <div className="bg-white p-6 rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead className="bg-slate-50 border-b border-slate-100">
              <tr>
                <th className="px-6 py-4 text-sm font-bold text-slate-500">Mã</th>
                <th className="px-6 py-4 text-sm font-bold text-slate-500">Khách</th>
                <th className="px-6 py-4 text-sm font-bold text-slate-500">Ngày</th>
                <th className="px-6 py-4 text-sm font-bold text-slate-500">Trạng thái</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-50">
              {bookings.map((b) => (
                <tr key={b.id} className="hover:bg-blue-50/10 transition-colors">
                  <td className="px-6 py-4">#{b.id}</td>
                  <td className="px-6 py-4">{b.customer}</td>
                  <td className="px-6 py-4">{b.date}</td>
                  <td className="px-6 py-4">{b.status}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default Bookings;
