import { useState } from "react";
import { createTour } from "../../../api/tour.js";

export default function TourForm() {
    const [form, setForm] = useState({
        name: "",
        price: "",
        status: "active",
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        await createTour(form);
        alert("Tạo tour thành công");
    };

    return (
        <form
            onSubmit={handleSubmit}
            className="bg-white p-6 rounded shadow max-w-xl"
        >
            <h2 className="text-xl font-bold mb-4">Thêm Tour</h2>

            <div className="mb-4">
                <label className="block mb-1">Tên tour</label>
                <input
                    className="w-full border px-3 py-2 rounded"
                    onChange={(e) =>
                        setForm({ ...form, name: e.target.value })
                    }
                />
            </div>

            <div className="mb-4">
                <label className="block mb-1">Giá</label>
                <input
                    type="number"
                    className="w-full border px-3 py-2 rounded"
                    onChange={(e) =>
                        setForm({ ...form, price: Number(e.target.value) })
                    }
                />
            </div>

            <button className="bg-blue-600 text-white px-4 py-2 rounded">
                Lưu
            </button>
        </form>
    );
}
