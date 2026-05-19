<template>
    <div class="min-h-screen w-screen flex flex-col md:flex-row overflow-hidden">

        <!-- LEFT SIDE -->
        <div
            class="w-full md:w-1/2 min-h-[40vh] md:min-h-screen bg-gradient-to-br from-[#5B1E35] to-[#8B3A62] flex items-center justify-center px-10 md:px-24 py-16">

            <div class="text-white max-w-lg">

                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-8">
                    Create <br />
                    Account
                </h1>

                <p class="text-lg md:text-2xl leading-relaxed opacity-90">
                    Join and manage your projects,
                    tasks, and productivity in one dashboard.
                </p>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div
            class="w-full md:w-1/2 min-h-[60vh] md:min-h-screen bg-[#F8EEF1] flex items-center justify-center px-8 md:px-24 py-16">

            <div class="w-full max-w-xl">

                <h2 class="text-5xl font-bold text-[#5B1E35] mb-3">
                    Register
                </h2>

                <p class="text-gray-500 text-lg mb-10">
                    Create your account
                </p>

                <!-- NAME -->
                <div class="mb-5">

                    <label class="block text-gray-700 mb-2">
                        Full Name
                    </label>

                    <input v-model="name" type="text" placeholder="Enter your name"
                        class="w-full px-6 py-5 rounded-2xl bg-white outline-none shadow-sm focus:ring-2 focus:ring-[#5B1E35]" />

                </div>

                <!-- EMAIL -->
                <div class="mb-5">

                    <label class="block text-gray-700 mb-2">
                        Email
                    </label>

                    <input v-model="email" type="email" placeholder="Enter your email"
                        class="w-full px-6 py-5 rounded-2xl bg-white outline-none shadow-sm focus:ring-2 focus:ring-[#5B1E35]" />

                </div>

                <!-- PASSWORD -->
                <div class="mb-5">

                    <label class="block text-gray-700 mb-2">
                        Password
                    </label>

                    <input v-model="password" type="password" placeholder="Enter your password"
                        class="w-full px-6 py-5 rounded-2xl bg-white outline-none shadow-sm focus:ring-2 focus:ring-[#5B1E35]" />

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-8">

                    <label class="block text-gray-700 mb-2">
                        Confirm Password
                    </label>

                    <input v-model="password_confirmation" type="password" placeholder="Confirm password"
                        class="w-full px-6 py-5 rounded-2xl bg-white outline-none shadow-sm focus:ring-2 focus:ring-[#5B1E35]" />

                </div>
                <!-- ROLE -->
                <div class="mb-5">

                    <label class="block text-gray-700 mb-2">
                        Role
                    </label>

                    <select v-model="role_id"
                        class="w-full px-6 py-5 rounded-2xl bg-white outline-none shadow-sm focus:ring-2 focus:ring-[#5B1E35]">

                        <option :value="2">
                            User
                        </option>

                        <option :value="1">
                            Admin
                        </option>

                    </select>

                </div>

                <!-- REGISTER BUTTON -->
                <button @click="register"
                    class="w-full bg-[#5B1E35] hover:bg-[#7A2D4B] text-white py-5 rounded-2xl text-lg font-semibold transition">
                    REGISTER
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
                <button @click="googleRegister"
                    class="w-full bg-white border border-gray-300 py-5 rounded-2xl hover:bg-gray-50 transition">
                    Continue with Google
                </button>

                <!-- LOGIN -->
                <div class="text-center mt-10 text-lg">

                    <span class="text-gray-500">
                        Already have an account?
                    </span>

                    <router-link to="/login" class="text-[#5B1E35] font-semibold ml-2 hover:underline">
                        Login
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
            name: "",
            email: "",
            role_id: 2,
            password: "",
            password_confirmation: ""
        };
    },

    methods: {

        async register() {

            try {

                await api.post("/register", {
                    name: this.name,
                    email: this.email,
                    role_id: this.role_id,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                });

                alert("Register berhasil");

                this.$nextTick(() => {
                     this.$router.replace('/');
                });

            } catch (error) {

                console.log(error);

                alert("Register gagal");
            }
        },

        googleRegister() {

            window.location.href =
                "http://127.0.0.1:8000/api/auth/google";
        }
    }
};
</script>