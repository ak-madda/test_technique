import { defineStore } from 'pinia'
import axios from 'axios'

export const useTaskStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    loading: false,
    error: null
  }),

  actions: {
    async fetchProjectTasks(projectId) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.get(`/api/projects/${projectId}/tasks`)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors du chargement des tâches'
        throw error
      } finally {
        this.loading = false
      }
    },

    async createTask(projectId, taskData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.post(`/api/projects/${projectId}/tasks`, taskData)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors de la création de la tâche'
        if (error.response?.status === 422) {
          throw error
        }
      } finally {
        this.loading = false
      }
    },

    async updateTask(id, taskData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.put(`/api/tasks/${id}`, taskData)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors de la modification de la tâche'
        if (error.response?.status === 422) {
          throw error
        }
      } finally {
        this.loading = false
      }
    },

    async updateTaskStatus(id, status) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.patch(`/api/tasks/${id}/status`, { status })
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors de la modification du statut'
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteTask(id) {
      this.loading = true
      this.error = null
      
      try {
        await axios.delete(`/api/tasks/${id}`)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors de la suppression de la tâche'
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})