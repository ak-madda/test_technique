<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Mes projets</h1>
      <router-link
        to="/projects/create"
        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
      >
        Nouveau projet
      </router-link>
    </div>

    <div v-if="loading" class="flex justify-center items-center h-64">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>

    <div v-else-if="projects.length === 0" class="text-center py-12">
      <p class="text-gray-500 text-lg">Aucun projet pour le moment</p>
      <router-link
        to="/projects/create"
        class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
      >
        Créer votre premier projet
      </router-link>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <ProjectCard
        v-for="project in projects"
        :key="project.id"
        :project="project"
      />
    </div>

    <div v-if="projects.length > 0" class="mt-8 flex justify-center">
      <button
        @click="loadMore"
        :disabled="!hasMore || loadingMore"
        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors disabled:opacity-50"
      >
        {{ loadingMore ? 'Chargement...' : 'Charger plus' }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import ProjectCard from '../components/ProjectCard.vue'
import { useProjectStore } from '../stores/projects'

const projectStore = useProjectStore()
const projects = ref([])
const loading = ref(false)
const loadingMore = ref(false)
const hasMore = ref(true)
const currentPage = ref(1)

const fetchProjects = async (page = 1) => {
  if (page === 1) {
    loading.value = true
  } else {
    loadingMore.value = true
  }

  try {
    const response = await projectStore.fetchProjects(page)
    if (page === 1) {
      projects.value = response.data
    } else {
      projects.value = [...projects.value, ...response.data]
    }
    hasMore.value = response.meta.current_page < response.meta.last_page
    currentPage.value = page
  } catch (error) {
    console.error('Error fetching projects:', error)
  } finally {
    loading.value = false
    loadingMore.value = false
  }
}

const loadMore = () => {
  if (hasMore.value) {
    fetchProjects(currentPage.value + 1)
  }
}

onMounted(() => {
  fetchProjects()
})
</script>