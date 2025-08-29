<template>
  <div 
    class="bg-white rounded-lg shadow p-4 mb-3 cursor-move"
    draggable="true"
    @dragstart="onDragStart"
    @dragend="onDragEnd"
    :class="{
      'border-l-4 border-red-500': task.priority === 'high',
      'border-l-4 border-yellow-500': task.priority === 'medium',
      'border-l-4 border-green-500': task.priority === 'low'
    }"
  >
    <div class="flex justify-between items-start mb-2">
      <h4 class="font-semibold text-gray-800">{{ task.title }}</h4>
      <span class="text-xs px-2 py-1 rounded-full" :class="statusClass">
        {{ statusText }}
      </span>
    </div>
    
    <p class="text-gray-600 text-sm mb-3">{{ task.description }}</p>
    
    <div class="flex justify-between items-center text-sm text-gray-500">
      <span v-if="task.assignee">Assigné à: {{ task.assignee.name }}</span>
      <span v-else>Non assigné</span>
      
      <div class="flex space-x-2">
        <button 
          @click.stop="$emit('edit', task)"
          class="text-blue-500 hover:text-blue-700"
        >
          Éditer
        </button>
        <button 
          @click.stop="$emit('delete', task.id)"
          class="text-red-500 hover:text-red-700"
        >
          Supprimer
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['edit', 'delete'])

const statusText = computed(() => {
  const statusMap = {
    pending: 'En attente',
    in_progress: 'En cours',
    completed: 'Terminée'
  }
  return statusMap[props.task.status] || props.task.status
})

const statusClass = computed(() => {
  return {
    pending: 'bg-yellow-100 text-yellow-800',
    in_progress: 'bg-blue-100 text-blue-800',
    completed: 'bg-green-100 text-green-800'
  }[props.task.status]
})

const onDragStart = (e) => {
  e.dataTransfer.setData('taskId', props.task.id.toString())
  e.dataTransfer.effectAllowed = 'move'
}

const onDragEnd = () => {
  // Optional: add visual feedback
}
</script>