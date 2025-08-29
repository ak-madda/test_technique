<template>
  <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
    <h3 class="text-xl font-semibold text-gray-800 mb-2">
      {{ project.name }}
    </h3>
    <p class="text-gray-600 mb-4">
      {{ project.description }}
    </p>
    <div class="flex justify-between items-center">
      <span class="text-sm text-gray-500">
        {{ project.tasks_count }} tâche(s)
      </span>
      <router-link
        :to="`/projects/${project.id}`"
        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors"
      >
        Voir le projet
      </router-link>
    </div>
  </div>
</template>

<script setup>
defineProps({
  project: {
    type: Object,
    required: true,
  },
});
</script>