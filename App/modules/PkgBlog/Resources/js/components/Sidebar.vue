<template>
    <aside :class="[
        'sidebar bg-gray-800 text-white transition-all duration-300 ease-in-out flex flex-col',
        isCollapsed ? 'w-16' : 'w-64',
    ]">
        <!-- Sidebar Header -->
        <div class="p-4 border-b border-gray-700">
            <h2 v-if="!isCollapsed" class="text-lg font-semibold">My Blog</h2>
            <h2 v-else class="text-lg font-semibold text-center">MB</h2>
        </div>

        <!-- Navigation Menu -->
        <div class="p-4 flex-1">
            <ul class="space-y-2">
                <li>
                    <router-link to="/" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Dashboard</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/articles" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Articles</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/categories" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3v18M18 3v18" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Categories</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/tags" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5a2 2 0 012 2v5.293a2 2 0 01-.586 1.414l-6.707 6.707a2 2 0 01-2.828 0l-3.172-3.172a2 2 0 010-2.828L5.293 7.586A2 2 0 016.707 7H7z" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Tags</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/comments" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6M9 11h6M9 15h6" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Comments</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/users" class="flex items-center p-2 hover:bg-gray-700 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm0 0c2.485 0 4.5-2.015 4.5-4.5S14.485 5 12 5 7.5 7.015 7.5 9.5 9.515 14 12 14z" />
                        </svg>
                        <span v-if="!isCollapsed" class="ml-2">Users</span>
                    </router-link>
                </li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-700">
            <div class="flex items-center">
                <img :src="user.avatar" :alt="user.name" class="w-8 h-8 rounded-full" />
                <div v-if="!isCollapsed" class="ml-3">
                    <p class="text-sm font-semibold">{{ user.name }}</p>
                    <p class="text-xs text-gray-400">{{ user.email }}</p>
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { ref } from 'vue';

const user = ref({
    name: 'John Doe',
    email: 'john.doe@example.com',
    avatar: '/avatars/john-doe.jpg',
});

// Collapsed state (passed from parent)
defineProps({
    isCollapsed: {
        type: Boolean,
        default: false,
    },
});
</script>
