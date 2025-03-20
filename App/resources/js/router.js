import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        redirect: "/dashboard", 
    },
    {
        path: "/dashboard",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/Dashboard.vue"
            ),
    },
    {
        path: "/articles",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/index.vue"
            ),
    },
    {
        path: "/articles/create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/create.vue"
            ),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
