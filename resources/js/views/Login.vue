<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const form = ref({
    email: '',
    password: ''
})

const login = async () => {
    if (await auth.login(form.value)) {
        router.push('/dashboard')
    }
}
</script>

<template>
    <form @submit.prevent="login">
        <input v-model="form.email" type="email">
        <input v-model="form.password" type="password">
        <button type="submit">Login</button>
    </form>
</template>