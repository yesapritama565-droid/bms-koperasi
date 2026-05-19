<template>
    <div class="min-h-screen bg-[#F8EEF1] flex">

        <!-- SIDEBAR -->
        <aside
            class="w-64 min-h-screen bg-gradient-to-b from-[#5B1E35] to-[#3D1224] flex flex-col shadow-2xl fixed top-0 left-0 z-30 transition-all duration-300"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            <div class="px-6 py-8 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">G</span>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm leading-tight">Garuda Merah</p>
                        <p class="text-white/60 text-xs">Putih Koperasi</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                    👤 Tim Member
                </span>
            </div>

            <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto">
                <p class="text-white/40 text-xs font-semibold uppercase px-3 mb-2 mt-2">Menu Saya</p>
                <button
                    v-for="item in menuItems" :key="item.name"
                    @click="activeMenu = item.name"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200"
                    :class="activeMenu === item.name
                        ? 'bg-white text-[#5B1E35] shadow-lg'
                        : 'text-white/70 hover:bg-white/10 hover:text-white'">
                    <span class="text-lg">{{ item.icon }}</span>
                    <span>{{ item.label }}</span>
                    <span v-if="item.badge"
                        class="ml-auto bg-[#E8B4C3] text-[#5B1E35] text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ item.badge }}
                    </span>
                </button>
            </nav>

            <div class="px-4 py-6 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                        {{ userInitial }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate">{{ user?.name }}</p>
                        <p class="text-white/50 text-xs truncate">{{ user?.email }}</p>
                    </div>
                    <button @click="logout" title="Logout"
                        class="text-white/50 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 ml-0 md:ml-64 flex flex-col min-h-screen">

            <!-- TOPBAR -->
            <header class="bg-white border-b border-[#E8D0DA] px-6 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-[#5B1E35]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-[#5B1E35]">
                            Halo, {{ firstName }}! 👋
                        </h1>
                        <p class="text-gray-400 text-xs">{{ currentDate }}</p>
                    </div>
                </div>
            </header>

            <!-- LOADING -->
            <div v-if="loading" class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <div class="w-12 h-12 border-4 border-[#5B1E35] border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <p class="text-[#5B1E35] font-medium text-sm">Memuat data...</p>
                </div>
            </div>

            <!-- CONTENT -->
            <div v-else class="flex-1 p-6 space-y-6">

                <!-- HERO CARD -->
                <div class="bg-gradient-to-r from-[#5B1E35] to-[#8B3A62] rounded-2xl p-6 text-white flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-sm mb-1">Tugasmu hari ini</p>
                        <h2 class="text-3xl font-bold mb-3">{{ stats.total }} Tugas</h2>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full">
                                ✅ {{ stats.selesai }} selesai
                            </span>
                            <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full">
                                🔄 {{ stats.on_progress }} berjalan
                            </span>
                            <span v-if="stats.terlambat > 0" class="bg-red-400/40 text-white text-xs px-3 py-1 rounded-full">
                                ⚠️ {{ stats.terlambat }} terlambat
                            </span>
                        </div>
                    </div>
                    <div class="text-6xl opacity-80 hidden md:block">📋</div>
                </div>

                <!-- STATS MINI -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#FEF3F2]">📋</div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.total }}</p>
                        <p class="text-gray-400 text-xs mt-1">Total Tugas</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#FFFBEB]">⏳</div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.pending }}</p>
                        <p class="text-gray-400 text-xs mt-1">Pending</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#EFF6FF]">🔄</div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.on_progress }}</p>
                        <p class="text-gray-400 text-xs mt-1">Sedang Berjalan</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#F0FDF4]">✅</div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.selesai }}</p>
                        <p class="text-gray-400 text-xs mt-1">Selesai</p>
                    </div>
                </div>

                <!-- TASKS + DEADLINE -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- DAFTAR TUGAS SAYA -->
                    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-[#F0DDE5]">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#3D1224] text-lg">Tugas Saya</h3>
                            <div class="flex gap-2">
                                <button v-for="f in filterOptions" :key="f.value"
                                    @click="activeFilter = f.value"
                                    class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all"
                                    :class="activeFilter === f.value
                                        ? 'bg-[#5B1E35] text-white'
                                        : 'bg-[#F8EEF1] text-gray-500 hover:bg-[#E8D0DA]'">
                                    {{ f.label }}
                                </button>
                            </div>
                        </div>

                        <div v-if="filteredMyTasks.length === 0"
                            class="text-center py-10 text-gray-400">
                            <p class="text-3xl mb-2">📭</p>
                            <p class="text-sm">Tidak ada tugas untuk filter ini</p>
                        </div>

                        <div class="space-y-3">
                            <div v-for="task in filteredMyTasks" :key="task.id"
                                class="border border-[#F0DDE5] rounded-xl p-4 hover:border-[#C48CA8] transition-colors">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 flex-1 min-w-0">
                                        <!-- Checkbox update progress -->
                                        <input type="checkbox"
                                            :checked="task.status === 'selesai'"
                                            @change="toggleDone(task)"
                                            class="mt-1 w-4 h-4 accent-[#5B1E35] cursor-pointer flex-shrink-0"/>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate"
                                                :class="task.status === 'selesai' ? 'line-through text-gray-400' : ''">
                                                {{ task.title }}
                                            </p>
                                            <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                                <span class="text-xs text-gray-400">📁 {{ task.project || 'Tanpa project' }}</span>
                                                <span class="text-xs text-gray-400" v-if="task.deadline">
                                                    ⏰ {{ formatDate(task.deadline) }}
                                                </span>
                                                <span class="text-xs text-gray-400">{{ task.progress }}%</span>
                                            </div>
                                            <div class="mt-2 h-1.5 bg-[#F8EEF1] rounded-full overflow-hidden">
                                                <div class="h-full rounded-full bg-gradient-to-r from-[#5B1E35] to-[#8B3A62] transition-all"
                                                    :style="{ width: task.progress + '%' }"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs px-2.5 py-1 rounded-lg font-medium flex-shrink-0 capitalize"
                                        :class="{
                                            'bg-red-50 text-red-500': task.priority === 'tinggi',
                                            'bg-yellow-50 text-yellow-600': task.priority === 'sedang',
                                            'bg-green-50 text-green-600': task.priority === 'rendah',
                                        }">
                                        {{ task.priority }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PANEL KANAN -->
                    <div class="space-y-5">

                        <!-- Deadline Terdekat -->
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">
                            <h3 class="font-bold text-[#3D1224] mb-4">⏰ Deadline Terdekat</h3>
                            <div v-if="upcomingDeadlines.length === 0"
                                class="text-center py-4 text-gray-400 text-sm">Tidak ada deadline terdekat</div>
                            <div class="space-y-3">
                                <div v-for="task in upcomingDeadlines" :key="task.id"
                                    class="flex items-center gap-3 p-2.5 rounded-xl"
                                    :class="isUrgent(task.deadline) ? 'bg-red-50' : 'bg-[#F8EEF1]'">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0"
                                        :class="isUrgent(task.deadline) ? 'bg-red-100' : 'bg-[#E8D0DA]'">
                                        📌
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-700 truncate">{{ task.title }}</p>
                                        <p class="text-xs font-bold mt-0.5"
                                            :class="isUrgent(task.deadline) ? 'text-red-500' : 'text-[#5B1E35]'">
                                            {{ formatDate(task.deadline) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Update Progress -->
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">
                            <h3 class="font-bold text-[#3D1224] mb-4">📊 Update Progress</h3>
                            <div v-if="activeTasks.length === 0"
                                class="text-center py-4 text-gray-400 text-sm">Tidak ada tugas aktif</div>
                            <div class="space-y-4">
                                <div v-for="task in activeTasks" :key="'p-' + task.id">
                                    <div class="flex justify-between mb-1">
                                        <p class="text-xs font-medium text-gray-700 truncate max-w-[160px]">{{ task.title }}</p>
                                        <span class="text-xs font-bold text-[#5B1E35]">{{ task.progress }}%</span>
                                    </div>
                                    <input type="range" min="0" max="100"
                                        :value="task.progress"
                                        @change="updateProgress(task, $event.target.value)"
                                        class="w-full accent-[#5B1E35] cursor-pointer h-1.5"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- MOBILE OVERLAY -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-20 md:hidden"></div>

    </div>
</template>

<script>
import api from "../services/api";

export default {
    name: "UserDashboard",

    data() {
        return {
            sidebarOpen: false,
            activeMenu: "dashboard",
            activeFilter: "semua",
            loading: true,

            user: null,
            tasks: [],

            stats: {
                total: 0,
                pending: 0,
                on_progress: 0,
                selesai: 0,
                terlambat: 0,
            },

            filterOptions: [
                { label: "Semua", value: "semua" },
                { label: "Aktif", value: "aktif" },
                { label: "Selesai", value: "selesai" },
            ],

            currentDate: new Date().toLocaleDateString("id-ID", {
                weekday: "long", year: "numeric", month: "long", day: "numeric",
            }),

            menuItems: [
                { name: "dashboard", label: "Dashboard", icon: "🏠", badge: null },
                { name: "tasks", label: "Tugas Saya", icon: "✅", badge: null },
                { name: "log", label: "Log Aktivitas", icon: "📊", badge: null },
            ],
        };
    },

    computed: {
        userInitial() {
            return this.user?.name?.charAt(0).toUpperCase() ?? "U";
        },
        firstName() {
            return this.user?.name?.split(" ")[0] ?? "User";
        },

        // Tugas milik user ini saja
        myTasks() {
            if (!this.user) return [];
            return this.tasks.filter(t => t.assigned_to === this.user.id);
        },

        // Filter berdasarkan tab
        filteredMyTasks() {
            if (this.activeFilter === "selesai") {
                return this.myTasks.filter(t => t.status === "selesai");
            }
            if (this.activeFilter === "aktif") {
                return this.myTasks.filter(t => t.status !== "selesai");
            }
            return this.myTasks;
        },

        // 3 tugas dengan deadline terdekat (yang belum selesai)
        upcomingDeadlines() {
            return this.myTasks
                .filter(t => t.deadline && t.status !== "selesai")
                .sort((a, b) => new Date(a.deadline) - new Date(b.deadline))
                .slice(0, 3);
        },

        // Tugas on_progress untuk slider update progress
        activeTasks() {
            return this.myTasks
                .filter(t => t.status === "on_progress" || t.status === "pending")
                .slice(0, 3);
        },
    },

    mounted() {
        const stored = localStorage.getItem("user");
        if (stored) {
            this.user = JSON.parse(stored);
        }
        this.fetchTasks();
    },

    methods: {
        // ─── FETCH TASKS DARI API ────────────────────────────────────────
        async fetchTasks() {
            this.loading = true;
            try {
                const res = await api.get("/tasks");
                this.tasks = Array.isArray(res.data) ? res.data : (res.data.data ?? []);
                this.computeStats();
            } catch (error) {
                console.error("Gagal memuat tugas:", error);
            } finally {
                this.loading = false;
            }
        },

        // ─── HITUNG STATS DARI TUGAS SENDIRI ────────────────────────────
        computeStats() {
            const mine = this.myTasks;
            this.stats.total = mine.length;
            this.stats.pending = mine.filter(t => t.status === "pending").length;
            this.stats.on_progress = mine.filter(t => t.status === "on_progress").length;
            this.stats.selesai = mine.filter(t => t.status === "selesai").length;
            this.stats.terlambat = mine.filter(t => t.status === "terlambat").length;

            const tasksMenu = this.menuItems.find(m => m.name === "tasks");
            if (tasksMenu) {
                const aktif = this.stats.pending + this.stats.on_progress;
                tasksMenu.badge = aktif > 0 ? String(aktif) : null;
            }
        },

        // ─── CENTANG TUGAS SELESAI ───────────────────────────────────────
        async toggleDone(task) {
            const newStatus = task.status === "selesai" ? "on_progress" : "selesai";
            const newProgress = newStatus === "selesai" ? 100 : task.progress;
            try {
                await api.put(`/tasks/${task.id}`, {
                    ...task,
                    status: newStatus,
                    progress: newProgress,
                });
                task.status = newStatus;
                task.progress = newProgress;
                this.computeStats();
            } catch (error) {
                console.error("Gagal update status tugas:", error);
            }
        },

        // ─── UPDATE PROGRESS VIA SLIDER ─────────────────────────────────
        async updateProgress(task, value) {
            const progress = Number(value);
            try {
                await api.put(`/tasks/${task.id}`, {
                    ...task,
                    progress,
                    status: progress === 100 ? "selesai" : task.status,
                });
                task.progress = progress;
                if (progress === 100) task.status = "selesai";
                this.computeStats();
            } catch (error) {
                console.error("Gagal update progress:", error);
            }
        },

        // ─── LOGOUT ──────────────────────────────────────────────────────
        async logout() {
            try {
                await api.post("/logout");
            } catch (_) {}
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            this.$router.push("/login");
        },

        isUrgent(deadline) {
            const diff = new Date(deadline) - new Date();
            return diff < 86400000; // < 24 jam
        },

        formatDate(val) {
            return new Date(val).toLocaleDateString("id-ID", {
                day: "numeric", month: "short", year: "numeric",
            });
        },
    },
};
</script>