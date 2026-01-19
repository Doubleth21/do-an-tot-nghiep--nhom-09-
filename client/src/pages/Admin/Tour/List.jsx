import { useEffect, useState } from "react";
import { getTours, deleteTour } from "../../../api/tour";

export default function TourList() {
    const [tours, setTours] = useState([]);

    const fetchTours = async () => {
        const res = await getTours();
        setTours(res.data);
    };

    useEffect(() => {
        fetchTours();
    }, []);

    const handleDelete = async (id) => {
        if (!confirm("Xóa tour này?")) return;
        await deleteTour(id);
        fetchTours();
    };

    return (
        <div>
            <div className="flex justify-between mb-4">
                <h2 className="text-2xl font-bold">Quản lý Tour</h2>
                <button className="bg-blue-600 text-white px-4 py-2 rounded">
                    + Thêm tour
                </button>
            </div>

            <table className="w-full bg-white rounded shadow">
                <thead className="bg-gray-100">
                    <tr>
                        <th className="p-3 text-left">Tên tour</th>
                        <th className="p-3">Giá</th>
                        <th className="p-3">Trạng thái</th>
                        <th className="p-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    {tours.map((tour) => (
                        <tr key={tour.id} className="border-t">
                            <td className="p-3">{tour.name}</td>
                            <td className="p-3 text-center">
                                {tour.price.toLocaleString()} đ
                            </td>
                            <td className="p-3 text-center">
                                <span
                                    className={`px-2 py-1 rounded text-sm ${tour.status === "active"
                                        ? "bg-green-100 text-green-700"
                                        : "bg-red-100 text-red-700"
                                        }`}
                                >
                                    {tour.status}
                                </span>
                            </td>
                            <td className="p-3 text-center space-x-2">
                                <button className="text-blue-600">Sửa</button>
                                <button
                                    className="text-red-600"
                                    onClick={() => handleDelete(tour.id)}
                                >
                                    Xóa
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
