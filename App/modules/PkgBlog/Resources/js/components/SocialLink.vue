<template>
    <a href="#" class="flex items-center text-white hover:text-gray-200 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor"
            v-html="getIconSvg()"></svg>
        {{ props.network }}
    </a>
</template>

<script setup>
const props = defineProps({
    network: String,
    icon: String
});

const getIconSvg = () => {
    switch (props.icon) {
        case 'twitter':
            return `<path d="M24 4.557c..."></path>`;
        case 'instagram':
            return `<path d="M12 2.163c..."></path>`;
        case 'linkedin':
            return `<path d="M4.98 3.5c..."></path>`;
        case 'facebook':
            return `<path d="M9 8h-3v4..."></path>`;
        default:
            return '';
    }
};
</script>