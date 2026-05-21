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
                        <p class="text-white font-bold text-sm leading-tight">
                            Garuda Merah
                        </p>
                        <p class="text-white/60 text-xs">
                            Putih Koperasi
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                    👤 Tim Member
                </span>
            </div>

            <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto">
                <p class="text-white/40 text-xs font-semibold uppercase px-3 mb-2 mt-2">
                    Menu Saya
                </p>

                <button v-for="item in menuItems" :key="item.name" @click="goToMenu(item.name)"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200"
                    :class="activeMenu === item.name
                            ? 'bg-white text-[#5B1E35] shadow-lg'
                            : 'text-white/70 hover:bg-white/10 hover:text-white'
                        ">
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
                    <div
                        class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                        {{ userInitial }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate">
                            {{ user?.name }}
                        </p>

                        <p class="text-white/50 text-xs truncate">
                            {{ user?.email }}
                        </p>
                    </div>

                    <button @click="logout" title="Logout" class="text-white/50 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 ml-0 md:ml-64 flex flex-col min-h-screen">

            <!-- TOPBAR -->
            <header
                class="bg-white border-b border-[#E8D0DA] px-6 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-[#5B1E35]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-xl font-bold text-[#5B1E35]">
                            Halo, {{ firstName }}! 👋
                        </h1>

                        <p class="text-gray-400 text-xs">
                            {{ currentDate }}
                        </p>
                    </div>
                </div>
            </header>

            <!-- LOADING -->
            <div v-if="loading" class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <div
                        class="w-12 h-12 border-4 border-[#5B1E35] border-t-transparent rounded-full animate-spin mx-auto mb-3">
                    </div>

                    <p class="text-[#5B1E35] font-medium text-sm">
                        Memuat data...
                    </p>
                </div>
            </div>

            <!-- CONTENT -->
            <div v-else class="flex-1 p-6 space-y-6">

                <!-- HEADER DASHBOARD -->
                <div class="bg-gradient-to-r from-[#5B1E35] to-[#8B3A62] rounded-3xl p-7 text-white shadow-lg">

                    <div class="flex items-center justify-between flex-wrap gap-5">

                        <div>
                            <p class="text-white/70 text-sm mb-2">
                                Dashboard Task Management
                            </p>

                            <h2 class="text-3xl font-bold mb-3">
                                Monitoring Kinerja Tim
                            </h2>

                            <div class="flex gap-3 flex-wrap">

                                <div class="bg-white/20 px-4 py-2 rounded-xl text-sm">
                                    📋 {{ stats.total }} Total Tugas
                                </div>

                                <div class="bg-white/20 px-4 py-2 rounded-xl text-sm">
                                    ✅ {{ stats.selesai }} Selesai
                                </div>

                                <div class="bg-white/20 px-4 py-2 rounded-xl text-sm">
                                    ⏳ {{ stats.pending }} Pending
                                </div>

                                <div class="bg-white/20 px-4 py-2 rounded-xl text-sm">
                                    ⚠️ {{ stats.terlambat }} Terlambat
                                </div>

                            </div>
                        </div>

                        <div class="hidden md:block text-7xl opacity-20">
                            📊
                        </div>

                    </div>
                </div>

                <!-- CARD STATISTIK -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

                    <!-- TOTAL TASK -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-gray-400 text-sm">
                                    Total Task
                                </p>

                                <h2 class="text-3xl font-bold text-[#3D1224] mt-2">
                                    {{ stats.total }}
                                </h2>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-[#FCE7F3] flex items-center justify-center text-2xl">
                                📋
                            </div>

                        </div>
                    </div>

                    <!-- TASK SELESAI -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-gray-400 text-sm">
                                    Task Selesai
                                </p>

                                <h2 class="text-3xl font-bold text-green-600 mt-2">
                                    {{ stats.selesai }}
                                </h2>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                                ✅
                            </div>

                        </div>
                    </div>

                    <!-- ON PROGRESS -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-gray-400 text-sm">
                                    Sedang Berjalan
                                </p>

                                <h2 class="text-3xl font-bold text-blue-600 mt-2">
                                    {{ stats.on_progress }}
                                </h2>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                                🔄
                            </div>

                        </div>
                    </div>

                    <!-- TERLAMBAT -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5]">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-gray-400 text-sm">
                                    Task Terlambat
                                </p>

                                <h2 class="text-3xl font-bold text-red-500 mt-2">
                                    {{ stats.terlambat }}
                                </h2>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                                ⚠️
                            </div>

                        </div>
                    </div>

                </div>

                <!-- ANALYTIC -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- PROGRESS TIM -->
                    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-[#F0DDE5]">

                        <div class="flex items-center justify-between mb-6">

                            <div>
                                <h3 class="font-bold text-[#3D1224] text-lg">
                                    Progress Tim
                                </h3>

                                <p class="text-sm text-gray-400">
                                    Monitoring capaian tugas anggota
                                </p>
                            </div>

                            <div class="bg-[#F8EEF1] px-4 py-2 rounded-xl text-sm text-[#5B1E35] font-semibold">
                                {{ stats.selesai }}/{{ stats.total }} Task
                            </div>

                        </div>

                        <!-- BAR -->
                        <div class="space-y-5">

                            <div>

                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600">
                                        Penyelesaian Task
                                    </span>

                                    <span class="text-sm font-bold text-[#5B1E35]">
                                        {{ stats.total ? Math.round((stats.selesai / stats.total) * 100) : 0 }}%
                                    </span>
                                </div>

                                <div class="h-4 bg-[#F8EEF1] rounded-full overflow-hidden">

                                    <div class="h-full bg-gradient-to-r from-[#5B1E35] to-[#8B3A62] rounded-full transition-all duration-500"
                                        :style="{
                                            width: (stats.total
                                                ? (stats.selesai / stats.total) * 100
                                                : 0) + '%'
                                        }">

                                    </div>

                                </div>
                            </div>

                            <div>

                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600">
                                        Progress Project
                                    </span>

                                    <span class="text-sm font-bold text-blue-600">
                                        {{ stats.on_progress * 10 }}%
                                    </span>
                                </div>

                                <div class="h-4 bg-[#F8EEF1] rounded-full overflow-hidden">

                                    <div class="h-full bg-blue-500 rounded-full transition-all duration-500" :style="{
                                        width: (stats.on_progress * 10) + '%'
                                    }">

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- PREDICTIVE ANALYTIC -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#F0DDE5]">

                        <h3 class="font-bold text-[#3D1224] text-lg mb-5">
                            🤖 Predictive Analytic
                        </h3>

                        <div class="space-y-4">

                            <div class="bg-[#F8EEF1] rounded-xl p-4">

                                <p class="text-sm text-gray-500 mb-1">
                                    Goal Mingguan
                                </p>

                                <p class="text-xl font-bold text-[#5B1E35]">
                                    85%
                                </p>
                            </div>

                            <div class="bg-[#F8EEF1] rounded-xl p-4">

                                <p class="text-sm text-gray-500 mb-1">
                                    Estimasi Penyelesaian
                                </p>

                                <p class="text-xl font-bold text-green-600">
                                    Tepat Waktu
                                </p>
                            </div>

                            <div class="bg-[#F8EEF1] rounded-xl p-4">

                                <p class="text-sm text-gray-500 mb-1">
                                    Beban Tim
                                </p>

                                <p class="text-xl font-bold text-orange-500">
                                    Sedang
                                </p>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </main>

            <!-- MOBILE OVERLAY -->
            <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-20 md:hidden"></div>

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

                {
                    name: "dashboard",
                    label: "Dashboard",
                    icon: "🏠",
                    badge: null
                },

                {
                    name: "daily-activity",
                    label: "Daily Activity",
                    icon: "📋",
                    badge: null
                },

                {
                    name: "kanban",
                    label: "Kanban Board",
                    icon: "📌",
                    badge: null
                },

                {
                    name: "project",
                    label: "Project",
                    icon: "📁",
                    badge: null
                },

                {
                    name: "document",
                    label: "Document Management",
                    icon: "📂",
                    badge: null
                },

                {
                    name: "meeting",
                    label: "Notulensi Meeting",
                    icon: "📝",
                    badge: null
                },

                {
                    name: "announcement",
                    label: "Blast / Pengumuman",
                    icon: "📢",
                    badge: null
                },

                {
                    name: "log",
                    label: "Log Aktivitas",
                    icon: "📊",
                    badge: null
                },
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

            return this.tasks.filter(t => {
                return Number(t.assigned_to) === Number(this.user.id);
            });
        },

        // Filter berdasarkan tab
        filteredMyTasks() {
            if (this.activeFilter === "selesai") {
                return this.myTasks.filter(t => t.status === "selesai");
            }

            if (this.activeFilter === "aktif") {
                return this.myTasks.filter(t =>
                    ["pending", "on_progress", "terlambat"].includes(t.status)
                );
            }

            // WAJIB ADA
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

        //-------kanban----------
        goToMenu(name) {

            this.activeMenu = name;

            if (name === "dashboard") {
                this.$router.push("/");
            }

            else if (name === "kanban") {
                this.$router.push("/kanban");
            }

            else if (name === "daily-activity") {
                this.$router.push("/daily-activity");
            }

            else if (name === "project") {
                this.$router.push("/projects");
            }

            else if (name === "document") {
                this.$router.push("/documents");
            }

            else if (name === "meeting") {
                this.$router.push("/meeting-notes");
            }

            else if (name === "announcement") {
                this.$router.push("/announcements");
            }

            else if (name === "log") {
                this.$router.push("/activity-logs");
            }
        },
        // ─── HITUNG STATS DARI TUGAS SENDIRI ────────────────────────────
        computeStats() {
            const mine = this.myTasks || [];
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
            } catch (_) { }
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