import axios from "axios";

const axiosClient = axios.create({
    baseURL: "http://localhost:8000/api",
});

// tự động đính kèm token nếu có
axiosClient.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("auth_token");
        if (token) {
            config.headers = config.headers || {};
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

export default axiosClient;
