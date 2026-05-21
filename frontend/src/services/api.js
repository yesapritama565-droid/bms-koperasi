// ============================================================
//  services/api.js  –  Axios instance untuk BMS Koperasi GMP
//  Ganti BASE_URL sesuai URL backend Laravel kamu
// ============================================================

import axios from "axios";

// ← Ganti ini dengan URL backend kamu
const BASE_URL = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

const api = axios.create({
    baseURL: BASE_URL,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
    timeout: 15000,
});

// ─── REQUEST INTERCEPTOR: tambahkan Bearer Token ─────────────
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

// ─── RESPONSE INTERCEPTOR: handle 401 otomatis logout ────────
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            // Redirect ke login (sesuaikan jika pakai Vue Router)
            window.location.href = "/login";
        }
        return Promise.reject(error);
    }
);

export default api;