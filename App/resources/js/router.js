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
    {
        path: "/articles/:id",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/show.vue"
            ),
    },
    {
        path: "/articles/:id/edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/edit.vue"
            ),
    },
    {
        path: "/categories",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/index.vue"
            ),
    },
    {
        path: "/categories/:id/edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/edit.vue"
            ),
    },
    {
        path: "/categories/create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/create.vue"
            ),
    },
    {
        path: "/tags",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/index.vue"
            ),
    },
    {
        path: "/tags/create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/create.vue"
            ),
    },
    {
        path: "/tags/:id/edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/edit.vue"
            ),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
