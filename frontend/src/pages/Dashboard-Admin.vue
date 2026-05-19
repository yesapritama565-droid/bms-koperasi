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
                <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full capitalize">
                    👑 {{ user?.role?.replace('_', ' ') }}
                </span>
            </div>

            <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto">
                <p class="text-white/40 text-xs font-semibold uppercase px-3 mb-2 mt-2">Main Menu</p>
                <button v-for="item in menuItems" :key="item.name" @click="activeMenu = item.name"
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
                    <div
                        class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                        {{ userInitial }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate">{{ user?.name }}</p>
                        <p class="text-white/50 text-xs truncate">{{ user?.email }}</p>
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
                        <h1 class="text-xl font-bold text-[#5B1E35]">Dashboard Admin</h1>
                        <p class="text-gray-400 text-xs">{{ currentDate }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-2 bg-[#F8EEF1] rounded-xl px-4 py-2">
                        <svg class="w-4 h-4 text-[#8B3A62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                        </svg>
                        <input v-model="searchQuery" @input="filterTasks" type="text" placeholder="Cari tugas..."
                            class="bg-transparent text-sm outline-none text-gray-600 w-40" />
                    </div>
                    <div class="relative">
                        <button
                            class="w-10 h-10 bg-[#F8EEF1] rounded-xl flex items-center justify-center text-[#5B1E35] hover:bg-[#E8D0DA] transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                        <span v-if="stats.terlambat > 0"
                            class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-[10px] font-bold flex items-center justify-center">
                            {{ stats.terlambat }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- LOADING STATE -->
            <div v-if="loading" class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <div
                        class="w-12 h-12 border-4 border-[#5B1E35] border-t-transparent rounded-full animate-spin mx-auto mb-3">
                    </div>
                    <p class="text-[#5B1E35] font-medium text-sm">Memuat data...</p>
                </div>
            </div>

            <!-- CONTENT -->
            <div v-else class="flex-1 p-6 space-y-6">

                <!-- STATS CARDS (dari tasks API) -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div
                        class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5] hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#FEF3F2]">📋
                        </div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.total }}</p>
                        <p class="text-gray-400 text-xs mt-1">Total Tugas</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5] hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#F0FDF4]">✅
                        </div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.selesai }}</p>
                        <p class="text-gray-400 text-xs mt-1">Selesai</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5] hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#EFF6FF]">🔄
                        </div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.on_progress }}</p>
                        <p class="text-gray-400 text-xs mt-1">Sedang Berjalan</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-5 shadow-sm border border-[#F0DDE5] hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 bg-[#FFFBEB]">⚠️
                        </div>
                        <p class="text-2xl font-bold text-[#3D1224]">{{ stats.terlambat }}</p>
                        <p class="text-gray-400 text-xs mt-1">Terlambat</p>
                    </div>
                </div>

                <!-- TASKS TABLE -->
                <div class="bg-white rounded-2xl shadow-sm border border-[#F0DDE5] overflow-hidden">
                    <div
                        class="p-6 border-b border-[#F0DDE5] flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h3 class="font-bold text-[#3D1224] text-lg">Semua Tugas</h3>
                        <div class="flex items-center gap-3 flex-wrap">
                            <!-- Filter Status -->
                            <select v-model="filterStatus" @change="filterTasks"
                                class="text-sm bg-[#F8EEF1] text-gray-600 rounded-xl px-3 py-2 outline-none border-none">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="on_progress">On Progress</option>
                                <option value="selesai">Selesai</option>
                                <option value="terlambat">Terlambat</option>
                            </select>
                            <!-- Filter Prioritas -->
                            <select v-model="filterPriority" @change="filterTasks"
                                class="text-sm bg-[#F8EEF1] text-gray-600 rounded-xl px-3 py-2 outline-none border-none">
                                <option value="">Semua Prioritas</option>
                                <option value="tinggi">Tinggi</option>
                                <option value="sedang">Sedang</option>
                                <option value="rendah">Rendah</option>
                            </select>
                            <!-- Add Task Button -->
                            <button @click="openAddTask"
                                class="bg-[#5B1E35] text-white text-sm px-4 py-2 rounded-xl hover:bg-[#7A2D4B] transition font-medium">
                                + Tambah Tugas
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-[#F8EEF1]">
                                <tr>
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Judul
                                    </th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Project</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Ditugaskan</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Prioritas</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status
                                    </th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Progress</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Deadline</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="filteredTasks.length === 0">
                                    <td colspan="8" class="text-center py-12 text-gray-400">
                                        <p class="text-3xl mb-2">📭</p>
                                        <p>Belum ada tugas ditemukan</p>
                                    </td>
                                </tr>
                                <tr v-for="task in filteredTasks" :key="task.id"
                                    class="border-t border-[#F8EEF1] hover:bg-[#FDFAFC] transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-800 max-w-[180px] truncate">{{ task.title }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5 max-w-[180px] truncate">{{
                                            task.description }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600">{{ task.project || '-' }}</td>
                                    <td class="px-4 py-4">
                                        <span v-if="task.assigned_to_user" class="flex items-center gap-2">
                                            <span
                                                class="w-6 h-6 rounded-lg bg-[#E8D0DA] text-[#5B1E35] text-xs font-bold flex items-center justify-center">
                                                {{ task.assigned_to_user.name.charAt(0) }}
                                            </span>
                                            <span class="text-gray-700 text-xs">{{ task.assigned_to_user.name }}</span>
                                        </span>
                                        <span v-else class="text-gray-400 text-xs">-</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="text-xs px-2.5 py-1 rounded-lg font-semibold capitalize" :class="{
                                            'bg-red-50 text-red-500': task.priority === 'tinggi',
                                            'bg-yellow-50 text-yellow-600': task.priority === 'sedang',
                                            'bg-green-50 text-green-600': task.priority === 'rendah',
                                        }">
                                            {{ task.priority }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="text-xs px-2.5 py-1 rounded-lg font-semibold capitalize" :class="{
                                            'bg-gray-100 text-gray-500': task.status === 'pending',
                                            'bg-blue-50 text-blue-600': task.status === 'on_progress',
                                            'bg-green-50 text-green-600': task.status === 'selesai',
                                            'bg-red-50 text-red-500': task.status === 'terlambat',
                                        }">
                                            {{ task.status.replace('_', ' ') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-1.5 bg-[#F8EEF1] rounded-full w-16 overflow-hidden">
                                                <div class="h-full rounded-full bg-gradient-to-r from-[#5B1E35] to-[#8B3A62]"
                                                    :style="{ width: task.progress + '%' }"></div>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ task.progress }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-xs text-gray-500">
                                        {{ task.deadline ? formatDate(task.deadline) : '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2">
                                            <button @click="openEditTask(task)"
                                                class="w-7 h-7 rounded-lg bg-[#F8EEF1] hover:bg-[#E8D0DA] text-[#5B1E35] flex items-center justify-center transition text-xs">
                                                ✏️
                                            </button>
                                            <button @click="deleteTask(task.id)"
                                                class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 flex items-center justify-center transition text-xs">
                                                🗑️
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

        <!-- MOBILE OVERLAY -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-20 md:hidden"></div>

        <!-- MODAL TAMBAH / EDIT TUGAS -->
        <div v-if="showModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 animate-fadeIn">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-[#3D1224]">
                        {{ editMode ? 'Edit Tugas' : 'Tambah Tugas Baru' }}
                    </h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas *</label>
                        <input v-model="form.title" type="text" placeholder="Masukkan judul tugas"
                            class="w-full px-4 py-3 rounded-xl bg-[#F8EEF1] outline-none focus:ring-2 focus:ring-[#5B1E35] text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea v-model="form.description" placeholder="Deskripsi tugas (opsional)"
                            class="w-full px-4 py-3 rounded-xl bg-[#F8EEF1] outline-none focus:ring-2 focus:ring-[#5B1E35] text-sm resize-none h-20"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Project
                            </label>

                            <select v-model="form.project_id"
                                class="w-full px-4 py-3 rounded-xl bg-[#F8EEF1] outline-none focus:ring-2 focus:ring-[#5B1E35] text-sm">

                                <option value="">
                                    Pilih Project
                                </option>

                                <option v-for="project in projects" :key="project.id" :value="project.id">
                                    {{ project.name }}
                                </option>

                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                            <select v-model="form.priority"
                                class="w-full px-4 py-3 rounded-xl bg-[#F8EEF1] outline-none focus:ring-2 focus:ring-[#5B1E35] text-sm">
                                <option value="tinggi">Tinggi</option>
                                <option value="sedang">Sedang</option>
                                <option value="rendah">Rendah</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select v-model="form.status"
                                class="w-full px-4 py-3 rounded-xl bg-[#F8EEF1] outline-none focus:ring-2 focus:ring-[#5B1E35] text-sm">
                                <option value="pending">Pending</option>
                                <option value="on_progress">On Progress</option>
                                <option value="selesai">Selesai</option>
                                <option value="terlambat">Terlambat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Progress (%)</label>
                            <input v-model.number="form.progress" type="number" min="0" max="100"
                                class="w-full px-4 py-3 rounded-xl bg-[#F8EEF1] outline-none focus:ring-2 focus:ring-[#5B1E35] text-sm" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                        <input v-model="form.deadline" type="datetime-local"
                            class="w-full px-4 py-3 rounded-xl bg-[#F8EEF1] outline-none focus:ring-2 focus:ring-[#5B1E35] text-sm" />
                    </div>
                </div>

                <p v-if="formError" class="text-red-500 text-xs mt-3">{{ formError }}</p>

                <div class="flex gap-3 mt-6">
                    <button @click="closeModal"
                        class="flex-1 py-3 rounded-xl border border-[#E8D0DA] text-gray-600 text-sm font-medium hover:bg-[#F8EEF1] transition">
                        Batal
                    </button>
                    <button @click="submitTask" :disabled="submitting"
                        class="flex-1 py-3 rounded-xl bg-[#5B1E35] text-white text-sm font-semibold hover:bg-[#7A2D4B] transition disabled:opacity-60">
                        {{ submitting ? 'Menyimpan...' : (editMode ? 'Update Tugas' : 'Simpan Tugas') }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import api from "../services/api";

export default {
    name: "AdminDashboard",

    data() {
        return {
            users: [],
            sidebarOpen: false,
            activeMenu: "tasks",
            loading: true,
            submitting: false,
            showModal: false,
            editMode: false,
            searchQuery: "",
            filterStatus: "",
            filterPriority: "",
            formError: "",

            user: null,
            tasks: [],
            filteredTasks: [],

            stats: {
                total: 0,
                selesai: 0,
                on_progress: 0,
                terlambat: 0,
            },

            form: {
                project_id: '',

                title: '',

                description: '',

                priority: '',

                status: '',

                progress: 0,

                deadline: ''
            },

            currentDate: new Date().toLocaleDateString("id-ID", {
                weekday: "long", year: "numeric", month: "long", day: "numeric",
            }),

            menuItems: [
                { name: "dashboard", label: "Dashboard", icon: "🏠", badge: null },
                { name: "tasks", label: "Task Management", icon: "✅", badge: null },
                { name: "members", label: "Anggota Tim", icon: "👥", badge: null },
                { name: "settings", label: "Pengaturan", icon: "⚙️", badge: null },
            ],
        };
    },

    computed: {
        userInitial() {
            return this.user?.name?.charAt(0).toUpperCase() ?? "A";
        },
    },

    mounted() {
        // Ambil data user dari localStorage (disimpan saat login)
        const stored = localStorage.getItem("user");
        if (stored) {
            this.user = JSON.parse(stored);
        }
        this.fetchTasks();
    },

    methods: {
        // ─── FETCH SEMUA TASKS ───────────────────────────────────────────
        async fetchTasks() {
            this.loading = true;
            try {
                const res = await api.get("/tasks");
                // Sesuaikan dengan struktur response API kamu
                // Jika res.data adalah array langsung:
                this.tasks = Array.isArray(res.data) ? res.data : (res.data.data ?? []);
                this.computeStats();
                this.filterTasks();
            } catch (error) {
                console.error("Gagal memuat tugas:", error);
            } finally {
                this.loading = false;
            }
        },

        // ─── HITUNG STATISTIK DARI DATA TASKS ───────────────────────────
        computeStats() {
            this.stats.total = this.tasks.length;
            this.stats.selesai = this.tasks.filter(t => t.status === "selesai").length;
            this.stats.on_progress = this.tasks.filter(t => t.status === "on_progress").length;
            this.stats.terlambat = this.tasks.filter(t => t.status === "terlambat").length;
            // Update badge sidebar
            const tasksMenu = this.menuItems.find(m => m.name === "tasks");
            if (tasksMenu) tasksMenu.badge = this.stats.total > 0 ? String(this.stats.total) : null;
        },

        // ─── FILTER TASKS ────────────────────────────────────────────────
        filterTasks() {
            let result = [...this.tasks];
            if (this.searchQuery) {
                const q = this.searchQuery.toLowerCase();
                result = result.filter(t =>
                    t.title.toLowerCase().includes(q) ||
                    (t.description ?? "").toLowerCase().includes(q) ||
                    (t.project ?? "").toLowerCase().includes(q)
                );
            }
            if (this.filterStatus) {
                result = result.filter(t => t.status === this.filterStatus);
            }
            if (this.filterPriority) {
                result = result.filter(t => t.priority === this.filterPriority);
            }
            this.filteredTasks = result;
        },

        // ─── OPEN MODAL TAMBAH ───────────────────────────────────────────
        openAddTask() {
            this.editMode = false;
            this.formError = "";
            this.form = { id: null, title: "", description: "", project: "", priority: "sedang", status: "pending", progress: 0, deadline: "" };
            this.showModal = true;
        },

        // ─── OPEN MODAL EDIT ─────────────────────────────────────────────
        openEditTask(task) {
            this.editMode = true;
            this.formError = "";
            this.form = {
                id: task.id,
                title: task.title,
                description: task.description ?? "",
                project: task.project ?? "",
                priority: task.priority,
                status: task.status,
                progress: task.progress,
                deadline: task.deadline
                    ? new Date(task.deadline).toISOString().slice(0, 16)
                    : "",
            };
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        // ─── SUBMIT (CREATE / UPDATE) ────────────────────────────────────
        async submitTask() {
            if (!this.form.title.trim()) {
                this.formError = "Judul tugas wajib diisi.";
                return;
            }
            this.formError = "";
            this.submitting = true;
            try {
                const payload = {
                    title: this.form.title,
                    description: this.form.description,
                    project: this.form.project,
                    priority: this.form.priority,
                    status: this.form.status,
                    progress: this.form.progress,
                    deadline: this.form.deadline || null,
                };

                if (this.editMode) {
                    await api.put(`/tasks/${this.form.id}`, payload);
                } else {
                    await api.post("/tasks", payload);
                }

                this.closeModal();
                await this.fetchTasks();
            } catch (error) {
                this.formError = error.response?.data?.message ?? "Gagal menyimpan tugas.";
            } finally {
                this.submitting = false;
            }
        },

        // ─── DELETE TASK ─────────────────────────────────────────────────
        async deleteTask(id) {
            if (!confirm("Yakin ingin menghapus tugas ini?")) return;
            try {
                await api.delete(`/tasks/${id}`);
                await this.fetchTasks();
            } catch (error) {
                alert("Gagal menghapus tugas.");
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

        formatDate(val) {
            return new Date(val).toLocaleDateString("id-ID", {
                day: "numeric", month: "short", year: "numeric",
            });
        },
    },
};
</script>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.96);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>