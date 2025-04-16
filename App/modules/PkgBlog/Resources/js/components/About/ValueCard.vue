<template>
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div :class="['w-12 h-12 rounded-lg flex items-center justify-center mb-6', colorClasses.bg]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="colorClasses.text" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                v-html="iconPath"></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ title }}</h3>
        <p class="text-gray-700">
            {{ description }}
        </p>
    </div>
</template>

<script setup>
import { computed } from 'vue';
const props = defineProps({
    title: String,
    icon: String,
    color: String,
    description: String
});

const iconPath = computed(() => {
    switch (props.icon) {
        case 'pen-tool':
            return `<path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>`;
        case 'users':
            return `<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>`;
        case 'check-circle':
            return `<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>`;
        default:
            return '';
    }
});

const colorClasses = computed(() => {
    switch (props.color) {
        case 'purple':
            return {
                bg: 'bg-purple-100',
                text: 'text-purple-600'
            };
        case 'blue':
            return {
                bg: 'bg-blue-100',
                text: 'text-blue-600'
            };
        case 'green':
            return {
                bg: 'bg-green-100',
                text: 'text-green-600'
            };
        default:
            return {
                bg: 'bg-gray-100',
                text: 'text-gray-600'
            };
    }
});
</script>