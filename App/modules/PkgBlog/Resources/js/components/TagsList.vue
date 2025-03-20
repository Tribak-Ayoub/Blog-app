<template>
    <div v-if="tags && tags.length" class="mb-8">
        <h3 class="text-xl font-semibold text-gray-900">Tags</h3>
        <div class="flex flex-wrap gap-3 mt-4">
            <span v-for="tag in tags" :key="tag.id"
                class="px-5 py-3 bg-teal-200 text-teal-800 rounded-full text-sm font-medium transition duration-300 hover:bg-teal-300 hover:text-teal-900">
                {{ tag.name }}
            </span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    tags: Array,
});
</script>