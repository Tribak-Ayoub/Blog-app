<template>
    <router-link :to="`/articles/${article.id}/edit`"
        class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
        Edit
    </router-link>
</template>

<script setup>
defineProps({
    article: Object,
});
</script>

<style scoped>
/* Add button hover effects */
router-link:hover {
    transform: scale(1.05);
}
</style>