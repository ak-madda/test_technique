<template>
  <div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
      {{ project ? 'Modifier le projet' : 'Nouveau projet' }}
    </h1>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nom du projet</label>
        <input
          type="text"
          id="name"
          v-model="form.name"
          required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          :class="{ 'border-red-500': errors.name }"
        />
        <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name[0] }}</p>
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea
          id="description"
          v-model="form.description"
          rows="4"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          :class="{ 'border-red-500': errors.description }"
        ></textarea>
        <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description[0] }}</p>
      </div>

      <div class="flex justify-end space-x-3">
        <router-link
          to="/dashboard"
          class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Annuler
        </router-link>
        <button
          type="submit"
          :disabled="loading"
          class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
        >
          {{ loading ? 'Enregistrement...' : 'Enregistrer' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useProjectStore } from '../stores/projects'

const route = useRoute()
const router = useRouter()
const projectStore = useProjectStore()

const project = ref(null)
const loading = ref(false)
const errors = ref({})

const form = reactive({
  name: '',
  description: ''
})

const fetchProject = async () => {
  if (route.params.id) {
    try {
      project.value = await projectStore.fetchProject(route.params.id)
      form.name = project.value.name
      form.description = project.value.description || ''
    } catch (error) {
      console.error('Error fetching project:', error)
      router.push('/dashboard')
    }
  }
}

const handleSubmit = async () => {
  loading.value = true
  errors.value = {}

  try {
    if (project.value) {
      await projectStore.updateProject(project.value.id, form)
    } else {
      await projectStore.createProject(form)
    }
    router.push('/dashboard')
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors
    } else {
      console.error('Error saving project:', error)
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchProject()
})
</script>