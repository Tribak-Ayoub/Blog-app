<template>
    <div class="mb-8">
        <h1 class="text-4xl font-semibold text-gray-900 leading-tight">{{ title }}</h1>
        <div v-if="category" class="mt-2 text-gray-600 text-sm">
            <span class="font-medium text-blue-600">{{ category.name }}</span>
            <span class="mx-2">|</span>
            <span>Published on {{ publishedDate }}</span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    category: Object,
    publishedDate: String,
});
</script>

<style scoped>
h1 {
    background-image: linear-gradient(to right, #6ee7b7, #3b82f6);
    -webkit-background-clip: text;
    color: transparent;
}
</style>