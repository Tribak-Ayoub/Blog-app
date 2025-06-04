<template>
    <li>
        <router-link :to="to" class="flex items-center p-2 rounded transition hover:bg-gray-800">
            <component :is="iconComponent" class="w-5 h-5" stroke="currentColor" fill="none" stroke-width="2" />
            <span v-if="!collapsed" class="ml-3 whitespace-nowrap">{{ label }}</span>
        </router-link>
    </li>
</template>

<script setup>
import { computed } from 'vue';
import {
    HomeIcon,
    MenuIcon,
    ColumnsIcon,
    TagIcon,
    MessageSquareIcon,
    UsersIcon,
    LayoutDashboard
} from 'lucide-vue-next';

const props = defineProps({
    icon: String,
    label: String,
    to: [String, Object],
    collapsed: Boolean
});

const iconComponent = computed(() => {
    const icons = {
        home: HomeIcon,
        menu: MenuIcon,
        columns: ColumnsIcon,
        tag: TagIcon,
        'message-square': MessageSquareIcon,
        users: UsersIcon,
        LayoutDashboard: LayoutDashboard
    };
    return icons[props.icon] || HomeIcon;
});
</script>
