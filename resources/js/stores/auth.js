import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')),
        token: localStorage.getItem('token')
    }),

    getters: {
        isAuthenticated: (state) => !!state.token
    },

    actions: {
        async login(credentials) {
            try {
                const response = await axios.post('/api/login', credentials)
                this.token = response.data.token
                this.user = response.data.user
                
                // Store in localStorage
                localStorage.setItem('token', this.token)
                localStorage.setItem('user', JSON.stringify(this.user))
                
                // Set axios default header
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
                
                return true
            } catch (error) {
                return false
            }
        },

        logout() {
            this.user = null
            this.token = null
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            delete axios.defaults.headers.common['Authorization']
        }
    }
})