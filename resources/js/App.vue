<template>
  <div id="app">
    <nav v-if="isAuthenticated" class="bg-blue-600 text-white shadow-lg">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
          <router-link to="/dashboard" class="text-xl font-bold">
            TaskManager
          </router-link>
          
          <div class="flex items-center space-x-4">
            <span>Bonjour, {{ user?.name }}</span>
            <button
              @click="handleLogout"
              class="px-3 py-1 bg-blue-500 hover:bg-blue-700 rounded transition-colors"
            >
              Déconnexion
            </button>
          </div>
        </div>
      </div>
    </nav>
    
    <main>
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from './stores/auth'

const authStore = useAuthStore()
const router = useRouter()

const isAuthenticated = computed(() => authStore.isAuthenticated)
const user = computed(() => authStore.user)

const handleLogout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  min-height: 100vh;
  background-color: #f7fafc;
}
</style>