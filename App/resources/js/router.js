import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "./stores/auth";
import { watchEffect } from "vue";

const routes = [
    {
        path: "/",
        redirect: "/articles",
    },
    {
        path: "/test",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/admin/article/test.vue"),
        meta: { requiresAuth: false }, // Public route
    },
    {
        path: "/test-dashboard",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/admin/TestDashboard.vue"),
        meta: { requiresAuth: false }, // Public route
    },
    {
        path: "/home",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/public/Home.vue"),
        meta: { requiresAuth: false }, // Public route
    },
    {
        path: "/public/articles",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/public/Articles.vue"),
        meta: { requiresAuth: false }, // Public route
    },
    {
        path: "/public/articles/:id",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/public/Show.vue"),
        meta: { requiresAuth: false }, // Public route
    },
    {
        path: "/dashboard",
        component: () =>
            import(
                "../../modules/PkgBlog/Resources/js/pages/admin/Dashboard.vue"
            ),
        meta: { requiresAuth: true, role: "admin" },
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
    {
        path: "/unauthorized",
        component: () =>
            import("../../modules/PkgBlog/Resources/js/pages/Unauthorized.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (authStore.loading) {
        // Use watchEffect to delay navigation until loading is done
        const stopWatching = watchEffect(() => {
            if (!authStore.loading) {
                stopWatching(); // Stop watching once loading is complete
                router.push(to.fullPath); // Retry navigation
            }
        });

        return next(false); // Cancel current navigation attempt
    }

    // Public route (does not require authentication)
    if (to.meta.requiresAuth === false) {
        return next();
    }

    // If authentication is required but user is not logged in, redirect to login
    if (to.meta.requiresAuth && !authStore.user) {
        window.location.href = "/login";
        return;
    }

    // Check role-based access control
    if (to.meta.role && !authStore.hasRole(to.meta.role)) {
        return next("/unauthorized");
    }

    // Check permission-based access control
    if (to.meta.permission && !authStore.hasPermission(to.meta.permission)) {
        return next("/unauthorized");
    }

    next();
});

export default router;
