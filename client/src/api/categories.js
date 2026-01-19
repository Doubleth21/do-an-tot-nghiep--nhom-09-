import axiosClient from "./axios";

// GET: lấy danh sách danh mục
export const getCategories = () =>
    axiosClient.get("/category");

// GET: lấy chi tiết 1 danh mục
export const getCategory = (id) =>
    axiosClient.get(`/category/${id}`);

// POST: tạo danh mục mới
export const createCategory = (data) =>
    axiosClient.post("/category", data);

// PUT: cập nhật danh mục
export const updateCategory = (id, data) =>
    axiosClient.put(`/category/${id}`, data);

// DELETE: xoá danh mục
export const deleteCategory = (id) =>
    axiosClient.delete(`/category/${id}`);
