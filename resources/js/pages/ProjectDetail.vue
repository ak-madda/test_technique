<template>
  <div class="container mx-auto px-4 py-8">
    <div v-if="loading" class="flex justify-center items-center h-64">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>

    <div v-else-if="!project" class="text-center py-12">
      <p class="text-gray-500 text-lg">Projet non trouvé</p>
    </div>

    <div v-else>
      <div class="flex justify-between items-start mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800">{{ project.name }}</h1>
          <p class="text-gray-600 mt-2">{{ project.description }}</p>
        </div>
        <div class="flex space-x-3">
          <router-link
            :to="`/projects/${project.id}/edit`"
            class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors"
          >
            Modifier
          </router-link>
          <button
            @click="showTaskForm = true"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
          >
            Nouvelle tâche
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne: En attente -->
        <div class="bg-gray-100 rounded-lg p-4">
          <h3 class="font-semibold text-gray-700 mb-4">En attente</h3>
          <div
            class="min-h-200"
            @drop="onDrop($event, 'pending')"
            @dragover.prevent
            @dragenter.prevent
          >
            <TaskCard
              v-for="task in pendingTasks"
              :key="task.id"
              :task="task"
              @edit="editTask(task)"
              @delete="deleteTask(task.id)"
            />
          </div>
        </div>

        <!-- Colonne: En cours -->
        <div class="bg-gray-100 rounded-lg p-4">
          <h3 class="font-semibold text-gray-700 mb-4">En cours</h3>
          <div
            class="min-h-200"
            @drop="onDrop($event, 'in_progress')"
            @dragover.prevent
            @dragenter.prevent
          >
            <TaskCard
              v-for="task in inProgressTasks"
              :key="task.id"
              :task="task"
              @edit="editTask(task)"
              @delete="deleteTask(task.id)"
            />
          </div>
        </div>

        <!-- Colonne: Terminée -->
        <div class="bg-gray-100 rounded-lg p-4">
          <h3 class="font-semibold text-gray-700 mb-4">Terminée</h3>
          <div
            class="min-h-200"
            @drop="onDrop($event, 'completed')"
            @dragover.prevent
            @dragenter.prevent
          >
            <TaskCard
              v-for="task in completedTasks"
              :key="task.id"
              :task="task"
              @edit="editTask(task)"
              @delete="deleteTask(task.id)"
            />
          </div>
        </div>
      </div>

      <!-- Modal de formulaire de tâche -->
      <div v-if="showTaskForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
          <h2 class="text-xl font-semibold mb-4">
            {{ editingTask ? 'Modifier la tâche' : 'Nouvelle tâche' }}
          </h2>
          <TaskForm
            :task="editingTask"
            :loading="formLoading"
            :errors="formErrors"
            @submit="handleTaskSubmit"
            @cancel="closeTaskForm"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import TaskCard from '../components/TaskCard.vue'
import TaskForm from '../components/TaskForm.vue'
import { useProjectStore } from '../stores/projects'
import { useTaskStore } from '../stores/tasks'

const route = useRoute()
const router = useRouter()
const projectStore = useProjectStore()
const taskStore = useTaskStore()

const project = ref(null)
const loading = ref(false)
const showTaskForm = ref(false)
const editingTask = ref(null)
const formLoading = ref(false)
const formErrors = ref({})

const pendingTasks = computed(() => 
  project.value?.tasks?.filter(task => task.status === 'pending') || []
)

const inProgressTasks = computed(() => 
  project.value?.tasks?.filter(task => task.status === 'in_progress') || []
)

const completedTasks = computed(() => 
  project.value?.tasks?.filter(task => task.status === 'completed') || []
)

const fetchProject = async () => {
  loading.value = true
  try {
    project.value = await projectStore.fetchProject(route.params.id)
  } catch (error) {
    console.error('Error fetching project:', error)
    if (error.response?.status === 404) {
      router.push('/dashboard')
    }
  } finally {
    loading.value = false
  }
}

const editTask = (task) => {
  editingTask.value = task
  showTaskForm.value = true
}

const closeTaskForm = () => {
  showTaskForm.value = false
  editingTask.value = null
  formErrors.value = {}
}

const handleTaskSubmit = async (formData) => {
  formLoading.value = true
  formErrors.value = {}

  try {
    if (editingTask.value) {
      await taskStore.updateTask(editingTask.value.id, formData)
    } else {
      await taskStore.createTask(project.value.id, formData)
    }
    closeTaskForm()
    await fetchProject() // Refresh project data
  } catch (error) {
    if (error.response?.status === 422) {
      formErrors.value = error.response.data.errors
    } else {
      console.error('Error saving task:', error)
    }
  } finally {
    formLoading.value = false
  }
}

const deleteTask = async (taskId) => {
  if (!confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
    return
  }

  try {
    await taskStore.deleteTask(taskId)
    await fetchProject() // Refresh project data
  } catch (error) {
    console.error('Error deleting task:', error)
  }
}

const onDrop = async (e, status) => {
  const taskId = e.dataTransfer.getData('taskId')
  if (!taskId) return

  try {
    await taskStore.updateTaskStatus(taskId, status)
    await fetchProject() // Refresh project data
  } catch (error) {
    console.error('Error updating task status:', error)
  }
}

onMounted(() => {
  fetchProject()
})
</script>

<style scoped>
.min-h-200 {
  min-height: 200px;
}
</style>