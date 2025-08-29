<template>
  <form @submit.prevent="handleSubmit" class="space-y-4">
    <div>
      <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
      <input
        type="text"
        id="title"
        v-model="form.title"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        :class="{ 'border-red-500': errors.title }"
      />
      <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title[0] }}</p>
    </div>

    <div>
      <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
      <textarea
        id="description"
        v-model="form.description"
        rows="3"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        :class="{ 'border-red-500': errors.description }"
      ></textarea>
      <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description[0] }}</p>
    </div>

    <div>
      <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
      <select
        id="status"
        v-model="form.status"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      >
        <option value="pending">En attente</option>
        <option value="in_progress">En cours</option>
        <option value="completed">Terminée</option>
      </select>
    </div>

    <div>
      <label for="priority" class="block text-sm font-medium text-gray-700">Priorité</label>
      <select
        id="priority"
        v-model="form.priority"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      >
        <option value="low">Basse</option>
        <option value="medium">Moyenne</option>
        <option value="high">Haute</option>
      </select>
    </div>

    <div>
      <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigné à</label>
      <select
        id="assigned_to"
        v-model="form.assigned_to"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      >
        <option :value="null">Non assigné</option>
        <option v-for="user in users" :key="user.id" :value="user.id">
          {{ user.name }}
        </option>
      </select>
    </div>

    <div>
      <label for="due_date" class="block text-sm font-medium text-gray-700">Date d'échéance</label>
      <input
        type="date"
        id="due_date"
        v-model="form.due_date"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      />
    </div>

    <div class="flex justify-end space-x-3">
      <button
        type="button"
        @click="$emit('cancel')"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
      >
        Annuler
      </button>
      <button
        type="submit"
        :disabled="loading"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
      >
        {{ loading ? 'En cours...' : 'Sauvegarder' }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { reactive, onMounted, watch } from 'vue'
import { useUserStore } from '../stores/auth'

const props = defineProps({
  task: {
    type: Object,
    default: null
  },
  loading: {
    type: Boolean,
    default: false
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const emit = defineEmits(['submit', 'cancel'])

const { users, fetchUsers } = useUserStore()

const form = reactive({
  title: '',
  description: '',
  status: 'pending',
  priority: 'medium',
  assigned_to: null,
  due_date: ''
})

// Populate form when editing an existing task
watch(() => props.task, (newTask) => {
  if (newTask) {
    form.title = newTask.title
    form.description = newTask.description || ''
    form.status = newTask.status
    form.priority = newTask.priority
    form.assigned_to = newTask.assigned_to
    form.due_date = newTask.due_date ? newTask.due_date.split('T')[0] : ''
  }
}, { immediate: true })

const handleSubmit = () => {
  emit('submit', form)
}

onMounted(fetchUsers)
</script>