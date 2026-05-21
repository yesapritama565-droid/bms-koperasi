<template>
    <div class="min-h-screen bg-[#F8EEF1] p-6">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-[#5B1E35] to-[#8B3A62] rounded-3xl p-7 text-white mb-6 shadow-lg">

            <div class="flex items-center justify-between flex-wrap gap-4">

                <div>
                    <p class="text-white/70 text-sm mb-2">
                        Task Management System
                    </p>

                    <h1 class="text-3xl font-bold mb-3">
                        Daily Activity
                    </h1>

                    <p class="text-white/80 max-w-2xl text-sm">
                        Monitoring aktivitas harian tim, task progress,
                        time tracking, approval tugas, dan kolaborasi kerja.
                    </p>
                </div>

                <div class="hidden md:block text-7xl opacity-20">
                    📋
                </div>

            </div>
        </div>

        <!-- MENU FITUR -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <!-- MENU 1 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">📝</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    Buat Tugas
                </h3>
            </div>

            <!-- MENU 2 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">📋</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    List Task
                </h3>
            </div>

            <!-- MENU 3 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">📆</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    Kalender
                </h3>
            </div>

            <!-- MENU 4 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">📊</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    Gantt Chart
                </h3>
            </div>

            <!-- MENU 5 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">📌</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    Kanban
                </h3>
            </div>

            <!-- MENU 6 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">⏱️</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    Time Tracking
                </h3>
            </div>

            <!-- MENU 7 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">💬</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    Komentar
                </h3>
            </div>

            <!-- MENU 8 -->
            <div class="bg-white rounded-2xl p-4 shadow-sm cursor-pointer hover:shadow-md transition">
                <div class="text-2xl mb-2">✅</div>
                <h3 class="font-semibold text-sm text-[#3D1224]">
                    Approval
                </h3>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    name: "DailyActivity",
};
</script>