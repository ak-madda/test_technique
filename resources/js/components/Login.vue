<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <form @submit.prevent="handleLogin" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        v-model="email" 
                        type="email" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input 
                        v-model="password" 
                        type="password" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    >
                </div>
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const email = ref('');
const password = ref('');

const handleLogin = async () => {
    const success = await authStore.login({
        email: email.value,
        password: password.value
    });

    if (success) {
        router.push('/dashboard');
    }
};
</script>