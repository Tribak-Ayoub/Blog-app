<template>
    <div v-if="content" class="mb-8 text-lg text-gray-800">
        <p>{{ content }}</p>
    </div>
</template>

<script setup>
defineProps({
    content: String,
});
</script>

<style scoped>
p {
    line-height: 1.7;
    letter-spacing: 0.5px;
}
</style>