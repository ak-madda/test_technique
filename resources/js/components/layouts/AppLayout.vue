<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <router-link :to="{ name: 'dashboard' }" class="flex items-center">
                            TaskManager
                        </router-link>
                    </div>
                    <div class="flex items-center">
                        <button @click="logout" class="text-gray-600 hover:text-gray-900">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <slot></slot>
        </main>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const logout = async () => {
    try {
        await axios.post('/api/logout');
        localStorage.removeItem('token');
        router.push('/login');
    } catch (error) {
        console.error('Logout failed:', error);
    }
};
</script>