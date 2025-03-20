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
        // meta: { requiresAuth: true, role: "admin" },
    },
    {
        path: "/articles",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/index.vue"
            ),
        meta: { requiresAuth: true, permission: "view article" },
    },
    {
        path: "/articles/create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/create.vue"
            ),
        meta: { requiresAuth: true, permission: "create article" },
    },
    {
        path: "/articles/:id",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/show.vue"
            ),
        meta: { requiresAuth: true, permission: "view article" },
    },
    {
        path: "/articles/:id/edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/article/edit.vue"
            ),
        meta: { requiresAuth: true, permission: "edit article" },
    },
    {
        path: "/categories",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/index.vue"
            ),
        meta: { requiresAuth: true, permission: "view category" },
    },
    {
        path: "/categories/:id/edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/edit.vue"
            ),
        meta: { requiresAuth: true, permission: "edit category" },
    },
    {
        path: "/categories/create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/category/create.vue"
            ),
        meta: { requiresAuth: true, permission: "create category" },
    },
    {
        path: "/tags",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/index.vue"
            ),
        meta: { requiresAuth: true, permission: "view tag" },
    },
    {
        path: "/tags/create",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/create.vue"
            ),
        meta: { requiresAuth: true, permission: "create tag" },
    },
    {
        path: "/tags/:id/edit",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/tag/edit.vue"
            ),
        meta: { requiresAuth: true, permission: "edit tag" },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
