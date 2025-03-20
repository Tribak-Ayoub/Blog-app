<template>
    <div v-if="comments.length" class="mt-8">
        <h3 class="text-xl font-semibold text-gray-900">Comments</h3>
        <div class="space-y-4 mt-4">
            <div v-for="comment in comments" :key="comment.id" class="p-4 bg-gray-50 rounded-lg shadow-sm">
                <div class="font-semibold text-gray-800">{{ comment.user.name }}</div>
                <p class="text-gray-600 mt-2">{{ comment.content }}</p>
            </div>
        </div>
    </div>
    <div v-else>
        <p class="text-gray-500">No comments yet. Be the first to comment!</p>
    </div>
</template>

<script setup>
defineProps({
    comments: Array,
});
</script>