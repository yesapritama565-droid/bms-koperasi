<template>
    <div class="min-h-screen bg-[#F8EEF1] p-6">

        <h1 class="text-2xl font-bold mb-6 text-[#3D1224]">
            Kanban Board Task
        </h1>

        <div v-if="loading" class="text-gray-500 mb-4">
            Loading tasks...
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- PENDING -->
            <div class="bg-white rounded-xl p-4 min-h-[500px]">
                <h2 class="font-bold mb-4 text-yellow-600">
                    🟡 Pending
                </h2>

                <draggable
                    v-model="pendingTasks"
                    group="tasks"
                    item-key="id"
                    class="space-y-3 min-h-[300px]"
                    @change="onDragChange"
                >
                    <template #item="{ element }">

                        <div class="p-3 bg-[#FFF7ED] rounded shadow-sm">

                            <p class="font-medium text-sm">
                                {{ element.title }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ element.project?.name || 'Tanpa Project' }}
                            </p>

                        </div>

                    </template>
                </draggable>
            </div>

            <!-- ON PROGRESS -->
            <div class="bg-white rounded-xl p-4 min-h-[500px]">

                <h2 class="font-bold mb-4 text-blue-600">
                    🔵 On Progress
                </h2>

                <draggable
                    v-model="progressTasks"
                    group="tasks"
                    item-key="id"
                    class="space-y-3 min-h-[300px]"
                    @change="onDragChange"
                >
                    <template #item="{ element }">

                        <div class="p-3 bg-[#EFF6FF] rounded shadow-sm">

                            <p class="font-medium text-sm">
                                {{ element.title }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ element.project?.name || 'Tanpa Project' }}
                            </p>

                        </div>

                    </template>
                </draggable>
            </div>

            <!-- DONE -->
            <div class="bg-white rounded-xl p-4 min-h-[500px]">

                <h2 class="font-bold mb-4 text-green-600">
                    🟢 Selesai
                </h2>

                <draggable
                    v-model="doneTasks"
                    group="tasks"
                    item-key="id"
                    class="space-y-3 min-h-[300px]"
                    @change="onDragChange"
                >
                    <template #item="{ element }">

                        <div class="p-3 bg-[#ECFDF5] rounded shadow-sm">

                            <p class="font-medium text-sm line-through">
                                {{ element.title }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ element.project?.name || 'Tanpa Project' }}
                            </p>

                        </div>

                    </template>
                </draggable>
            </div>

        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import api from "../services/api";

export default {
    name: "KanbanBoard",

    components: {
        draggable,
    },

    data() {
        return {
            tasks: [],
            loading: false,
        };
    },

    computed: {

        pendingTasks: {
            get() {
                return this.tasks.filter(
                    task => task.status === "pending"
                );
            },
            set(value) {
                value.forEach(task => {
                    task.status = "pending";
                });
            }
        },

        progressTasks: {
            get() {
                return this.tasks.filter(
                    task => task.status === "on_progress"
                );
            },
            set(value) {
                value.forEach(task => {
                    task.status = "on_progress";
                });
            }
        },

        doneTasks: {
            get() {
                return this.tasks.filter(
                    task => task.status === "selesai"
                );
            },
            set(value) {
                value.forEach(task => {
                    task.status = "selesai";
                });
            }
        },
    },

    mounted() {
        this.fetchTasks();
    },

    methods: {

        async fetchTasks() {
            this.loading = true;

            try {

                const res = await api.get("/tasks");

                this.tasks = Array.isArray(res.data)
                    ? res.data
                    : res.data.data || [];

            } catch (err) {

                console.error("Gagal load tasks:", err);

            } finally {

                this.loading = false;
            }
        },

        async onDragChange(event) {

            if (!event.added) return;

            const task = event.added.element;

            try {

                await api.put(`/tasks/${task.id}`, {
                    ...task,
                    status: task.status,
                });

            } catch (err) {

                console.error("Gagal update status:", err);
            }
        },
    },
};
</script>