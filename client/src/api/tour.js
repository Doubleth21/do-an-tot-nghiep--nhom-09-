import axiosClient from "./axios";

export const getTours = () => axiosClient.get("/tour");
export const getTour = (id) => axiosClient.get(`/tour/${id}`);
export const createTour = (data) => axiosClient.post("/tour", data);
export const updateTour = (id, data) =>
    axiosClient.put(`/tour/${id}`, data);
export const deleteTour = (id) =>
    axiosClient.delete(`/tour/${id}`);
