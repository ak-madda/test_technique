import { defineStore } from 'pinia'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('token'))
  const isAuthenticated = ref(false)
  const users = ref([])
  const router = useRouter()

  // Set default authorization header if token exists
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
    isAuthenticated.value = true
  }

  const setAuth = (userData, authToken) => {
    user.value = userData
    token.value = authToken
    isAuthenticated.value = true
    localStorage.setItem('token', authToken)
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`
  }

  const clearAuth = () => {
    user.value = null
    token.value = null
    isAuthenticated.value = false
    localStorage.removeItem('token')
    delete axios.defaults.headers.common['Authorization']
  }

  const register = async (credentials) => {
    try {
      const response = await axios.post('/api/register', credentials)
      setAuth(response.data.user, response.data.token)
      return response.data
    } catch (error) {
      clearAuth()
      throw error
    }
  }

  const login = async (credentials) => {
    try {
      const response = await axios.post('/api/login', credentials)
      setAuth(response.data.user, response.data.token)
      return response.data
    } catch (error) {
      clearAuth()
      throw error
    }
  }

  const logout = async () => {
    try {
      await axios.post('/api/logout')
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      clearAuth()
      router.push('/login')
    }
  }

  const fetchCurrentUser = async () => {
    try {
      const response = await axios.get('/api/user')
      user.value = response.data
      return response.data
    } catch (error) {
      clearAuth()
      throw error
    }
  }

  const fetchUsers = async () => {
    try {
      // This endpoint would need to be created in the backend
      const response = await axios.get('/api/users')
      users.value = response.data
      return response.data
    } catch (error) {
      console.error('Error fetching users:', error)
      throw error
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    users,
    register,
    login,
    logout,
    fetchCurrentUser,
    fetchUsers,
    clearAuth
  }
})