import { defineStore } from 'pinia'
import axios from 'axios'

export const useProjectStore = defineStore('projects', {
  state: () => ({
    projects: [],
    currentProject: null,
    loading: false,
    error: null
  }),

  actions: {
    async fetchProjects(page = 1) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.get(`/api/projects?page=${page}`)
        this.projects = page === 1 
          ? response.data.data 
          : [...this.projects, ...response.data.data]
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors du chargement des projets'
        throw error
      } finally {
        this.loading = false
      }
    },

    async fetchProject(id) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.get(`/api/projects/${id}`)
        this.currentProject = response.data.data
        return response.data.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors du chargement du projet'
        throw error
      } finally {
        this.loading = false
      }
    },

    async createProject(projectData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.post('/api/projects', projectData)
        this.projects.unshift(response.data.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors de la création du projet'
        if (error.response?.status === 422) {
          throw error
        }
      } finally {
        this.loading = false
      }
    },

    async updateProject(id, projectData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.put(`/api/projects/${id}`, projectData)
        const index = this.projects.findIndex(p => p.id === id)
        if (index !== -1) {
          this.projects[index] = response.data.data
        }
        if (this.currentProject?.id === id) {
          this.currentProject = response.data.data
        }
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors de la modification du projet'
        if (error.response?.status === 422) {
          throw error
        }
      } finally {
        this.loading = false
      }
    },

    async deleteProject(id) {
      this.loading = true
      this.error = null
      
      try {
        await axios.delete(`/api/projects/${id}`)
        this.projects = this.projects.filter(p => p.id !== id)
        if (this.currentProject?.id === id) {
          this.currentProject = null
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Erreur lors de la suppression du projet'
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})