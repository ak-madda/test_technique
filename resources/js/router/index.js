import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/LoginView.vue'),
        meta: { guest: true }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('../views/DashboardView.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/projects/:id',
        name: 'project-detail',
        component: () => import('../views/ProjectDetailView.vue'),
        meta: { requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if (to.meta.requiresAuth && !token) {
        next('/login');
    } else if (to.meta.guest && token) {
        next('/dashboard');
    } else {
        next();
    }
});

export default router;