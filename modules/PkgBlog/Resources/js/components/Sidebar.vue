<template>
    <aside :class="[
        'sidebar bg-gray-900 text-white transition-all duration-300 ease-in-out flex flex-col shadow-lg',
        isCollapsed ? 'w-16' : 'w-64'
    ]">
        <!-- Header -->
        <div class="p-4 border-b border-gray-800 flex justify-center">
            <h2 class="text-lg font-bold tracking-wide" :class="{ 'text-center': isCollapsed }">
                {{ isCollapsed ? 'I' : 'Insights' }}
            </h2>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-3">
            <ul class="space-y-2 text-sm">
                <!-- Dashboard -->
                <SidebarLink v-if="authStore.roles.includes('admin') || authStore.roles.includes('editor')" icon="LayoutDashboard"
                    label="Dashboard" :to="{ name: 'admin-dashboard' }" :collapsed="isCollapsed" />

                <!-- Home -->
                <SidebarLink  icon="home" label="Home"
                    :to="{ name: 'home' }" :collapsed="isCollapsed" />
                <!-- Articles -->
                <SidebarLink v-if="authStore.permissions.includes('view article')" icon="menu" label="Articles"
                    :to="{ name: 'admin-articles' }" :collapsed="isCollapsed" />

                <!-- Categories -->
                <SidebarLink v-if="authStore.permissions.includes('view category')" icon="columns" label="Categories"
                    :to="{ name: 'admin-categories' }" :collapsed="isCollapsed" />

                <!-- Tags -->
                <SidebarLink v-if="authStore.permissions.includes('view tag')" icon="tag" label="Tags"
                    :to="{ name: 'admin-tags' }" :collapsed="isCollapsed" />

                <!-- Comments -->
                <SidebarLink v-if="authStore.permissions.includes('view comment')" icon="message-square"
                    label="Comments" :to="{ name: 'admin-comments' }" :collapsed="isCollapsed" />

                <!-- Users -->
                <SidebarLink v-if="authStore.roles.includes('admin')" icon="users" label="Users" to="/users"
                    :collapsed="isCollapsed" />
            </ul>
        </nav>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-800 relative">
            <div class="flex items-center space-x-3 cursor-pointer" @click="toggleDropdown" role="button"
                aria-expanded="isDropdownOpen">
                <img v-if="authStore.user" :src="authStore.user.profile_image" class="w-8 h-8 rounded-full object-cover"
                    :alt="authStore.user.name || 'User avatar'" />
                <div v-if="authStore.user && !isCollapsed" class="overflow-hidden">
                    <p class="truncate font-semibold text-sm">{{ authStore.user.name }}</p>
                    <p class="truncate text-gray-400 text-xs">{{ authStore.user.email }}</p>
                </div>
            </div>

            <!-- Dropdown -->
            <transition name="fade">
                <ul v-if="isDropdownOpen"
                    class="absolute left-0 bottom-full transform -translate-y-2 w-52 bg-white text-gray-900 shadow-xl rounded-md p-2 z-50">
                    <li>
                        <a href="/profile" class="block px-4 py-2 hover:bg-gray-100 rounded">Profile</a>
                    </li>
                    <li>
                        <button @click="logout" class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded">
                            Log Out
                        </button>
                    </li>
                </ul>
            </transition>
        </div>
    </aside>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import SidebarLink from './SidebarLink.vue';

const authStore = useAuthStore();

defineProps({
    isCollapsed: {
        type: Boolean,
        default: false
    }
});

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const router = useRouter();

const logout = async () => {
    try {
        await axios.post('/logout');
        authStore.logout();
        window.location.href = '/';
    } catch (err) {
        console.error('Logout failed:', err);
    }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
