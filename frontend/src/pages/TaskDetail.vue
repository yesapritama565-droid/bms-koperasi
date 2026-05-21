<template>
  <div class="min-h-screen bg-[#F8EEF1] p-6">

    <div v-if="loading" class="text-center py-10">
      Loading...
    </div>

    <div v-else class="max-w-4xl mx-auto bg-white rounded-2xl p-6 shadow">

      <!-- HEADER -->
      <div class="flex justify-between items-start mb-4">
        <div>
          <h1 class="text-2xl font-bold text-[#3D1224]">
            {{ task.title }}
          </h1>
          <p class="text-gray-400 text-sm">
            Project: {{ task.project?.name || '-' }}
          </p>
        </div>

        <span class="px-3 py-1 text-xs rounded-full"
          :class="statusColor(task.status)">
          {{ task.status }}
        </span>
      </div>

      <!-- INFO -->
      <div class="grid grid-cols-2 gap-4 text-sm mb-6">
        <div>
          <p class="text-gray-400">Deadline</p>
          <p>{{ task.deadline }}</p>
        </div>

        <div>
          <p class="text-gray-400">Priority</p>
          <p>{{ task.priority }}</p>
        </div>

        <div>
          <p class="text-gray-400">Progress</p>
          <p>{{ task.progress }}%</p>
        </div>

        <div>
          <p class="text-gray-400">Assigned</p>
          <p>{{ task.assigned_to_user?.name }}</p>
        </div>
      </div>

      <!-- PROGRESS -->
      <div class="mb-6">
        <input type="range"
          min="0"
          max="100"
          v-model="task.progress"
          @change="updateProgress"
          class="w-full"
        />
      </div>

      <!-- DESCRIPTION -->
      <div class="mb-6">
        <p class="text-gray-400 text-sm mb-1">Description</p>
        <p>{{ task.description || '-' }}</p>
      </div>

      <!-- COMMENTS -->
      <div class="border-t pt-4">
        <h2 class="font-bold mb-3">Comments</h2>

        <div v-for="c in task.comments" :key="c.id"
          class="p-3 bg-[#F8EEF1] rounded mb-2">
          <p class="text-sm">{{ c.comment }}</p>
        </div>

        <div class="flex gap-2 mt-3">
          <input v-model="newComment"
            placeholder="Tulis komentar..."
            class="flex-1 border p-2 rounded"/>

          <button @click="sendComment"
            class="bg-[#5B1E35] text-white px-4 rounded">
            Kirim
          </button>
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
      task: {},
      loading: true,
      newComment: "",
    };
  },

  async mounted() {
    await this.fetchTask();
  },

  methods: {
    async fetchTask() {
      const id = this.$route.params.id;
      const res = await api.get(`/tasks/${id}`);
      this.task = res.data;
      this.loading = false;
    },

    async updateProgress() {
      await api.put(`/tasks/${this.task.id}`, {
        ...this.task
      });
    },

    async sendComment() {
      if (!this.newComment) return;

      await api.post("/task-comments", {
        task_id: this.task.id,
        comment: this.newComment,
      });

      this.newComment = "";
      this.fetchTask();
    },

    statusColor(status) {
      if (status === "selesai") return "bg-green-100 text-green-600";
      if (status === "on_progress") return "bg-blue-100 text-blue-600";
      if (status === "pending") return "bg-yellow-100 text-yellow-600";
      return "bg-gray-100 text-gray-600";
    }
  }
};
</script>