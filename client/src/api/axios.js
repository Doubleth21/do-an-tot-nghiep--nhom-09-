import axios from "axios";

const axiosClient = axios.create({
  baseURL: "http://localhost:8000/api",
});

// Nếu có token đã lưu, thiết lập header Authorization mặc định
const token = localStorage.getItem("token");
if (token) {
  axiosClient.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

export default axiosClient;
