import {createRouter, createWebHistory} from 'vue-router';

const routes = [
    { path: '/', component: () => import('../../modules/PkgBlog/Resources/js/pages/admin/Dashboard.vue') },
    { path: '/articles', component: () => import('../../modules/PkgBlog/Resources/js/pages/admin/article/index.vue') },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;