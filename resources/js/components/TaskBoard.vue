<template>
  <div class="flex gap-4">
    <div v-for="status in statuses" :key="status" class="w-1/3">
      <h3 class="text-lg font-bold mb-2">{{ status }}</h3>
      <div
        class="bg-gray-100 p-4 rounded min-h-[200px]"
        @drop="onDrop($event, status)"
        @dragover.prevent
      >
        <div
          v-for="task in tasksByStatus(status)"
          :key="task.id"
          class="bg-white p-4 mb-2 rounded shadow"
          draggable="true"
          @dragstart="onDragStart($event, task)"
        >
          <h4 class="font-bold">{{ task.title }}</h4>
          <p>{{ task.description }}</p>
          <div class="mt-2">
            <span class="text-sm text-gray-500">
              Assigned to: {{ task.assignee?.name }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  projectId: {
    type: Number,
    required: true
  }
});

const tasks = ref([]);
const statuses = ['todo', 'in_progress', 'done'];

const fetchTasks = async () => {
  const response = await axios.get(`/api/projects/${props.projectId}/tasks`);
  tasks.value = response.data.data;
};

const tasksByStatus = (status) => {
  return tasks.value.filter(task => task.status === status);
};

const onDragStart = (event, task) => {
  event.dataTransfer.setData('taskId', task.id);
};

const onDrop = async (event, newStatus) => {
  const taskId = event.dataTransfer.getData('taskId');
  await axios.patch(`/api/tasks/${taskId}`, { status: newStatus });
  await fetchTasks();
};

fetchTasks();
</script>