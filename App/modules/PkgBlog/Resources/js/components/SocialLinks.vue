<template>
    <div :class="wrapperClass">
        <slot />
    </div>
</template>

<script setup>
const props = defineProps({
    wrapperClass: {
        type: String,
        default: 'flex space-x-4',
    },
})
</script>