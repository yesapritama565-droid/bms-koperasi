<template>
    <div class="min-h-screen w-screen flex flex-col md:flex-row">

        <!-- LEFT SIDE -->

        <div
            class="w-full md:w-1/2 min-h-[50vh] md:min-h-screen bg-gradient-to-br from-[#5B1E35] to-[#8B3A62] flex items-center justify-center px-10 md:px-24 py-16">

            <div class="text-white max-w-lg">

                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-8">
                    TASK <br />
                    MANAGEMENT
                </h1>

                <p class="text-lg md:text-2xl leading-relaxed opacity-90">
                    Manage your task, project, and productivity
                    efficiently in one modern dashboard system.
                </p>

            </div>

        </div>

        <!-- RIGHT SIDE -->

        <div
            class="w-full md:w-1/2 min-h-[50vh] md:min-h-screen bg-[#F8EEF1] flex items-center justify-center px-8 md:px-24 py-16">

            <div class="w-full max-w-xl">

                <h2 class="text-5xl font-bold text-[#5B1E35] mb-3">
                    Login
                </h2>

                <p class="text-gray-500 text-lg mb-12">
                    Sign in to continue
                </p>

                <!-- EMAIL -->
                <div class="mb-6">

                    <label class="block text-gray-700 mb-2">
                        Email
                    </label>

                    <input v-model="email" type="email" placeholder="Enter your email"
                        class="w-full px-6 py-5 rounded-2xl bg-white outline-none shadow-sm focus:ring-2 focus:ring-[#5B1E35]" />

                </div>

                <!-- PASSWORD -->
                <div class="mb-4">

                    <label class="block text-gray-700 mb-2">
                        Password
                    </label>

                    <input v-model="password" type="password" placeholder="Enter your password"
                        class="w-full px-6 py-5 rounded-2xl bg-white outline-none shadow-sm focus:ring-2 focus:ring-[#5B1E35]" />

                </div>

                <!-- FORGOT -->
                <div class="text-right mb-8">

                    <button class="text-[#5B1E35] hover:underline">
                        Forgot Password?
                    </button>

                </div>

                <!-- LOGIN BUTTON -->
                <button @click="login"
                    class="w-full bg-[#5B1E35] hover:bg-[#7A2D4B] text-white py-5 rounded-2xl text-lg font-semibold transition">
                    LOGIN
                </button>

                <!-- DIVIDER -->
                <div class="flex items-center my-8">

                    <div class="flex-1 h-[1px] bg-gray-300"></div>

                    <span class="mx-4 text-gray-400">
                        OR
                    </span>

                    <div class="flex-1 h-[1px] bg-gray-300"></div>

                </div>

                <!-- GOOGLE -->
                <button @click="googleLogin"
                    class="w-full bg-white border border-gray-300 py-5 rounded-2xl hover:bg-gray-50 transition">
                    Continue with Google
                </button>

                <!-- REGISTER -->
                <div class="text-center mt-10 text-lg">

                    <span class="text-gray-500">
                        Don't have an account?
                    </span>

                    <router-link to="/register" class="text-[#5B1E35] font-semibold ml-2 hover:underline">
                        Register
                    </router-link>

                </div>

            </div>

        </div>

    </div>
</template>

<script>
import api from "../services/api";

export default {

    data() {
        return {
            email: "",
            password: ""
        };
    },

    methods: {

        async login() {
            try {
                const response = await api.post("/login", {
                    email: this.email,
                    password: this.password
                });

                const token = response.data.token;
                const user = response.data.user;

                // simpan ke localStorage
                localStorage.setItem("token", token);
                localStorage.setItem("user", JSON.stringify(user));

                alert("Login berhasil");

                // redirect berdasarkan role
                if (user.role_id === 1) {
                    this.$router.push("/Dashboard-Admin");
                } else {
                    this.$router.push("/Dashboard-User");
                }
            } catch (error) {
                alert("Email atau password salah");
                console.log(error);
            }
        },

        googleLogin() {

            window.location.href =
                "http://127.0.0.1:8000/api/auth/google";
        }
    }
};
</script>