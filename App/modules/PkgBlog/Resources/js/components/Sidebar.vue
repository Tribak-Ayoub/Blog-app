<template>
    <Sidebar v-model:visible="sidebarVisible" class="sidebar">
        <h3>Menu</h3>
        <ul>
            <li><router-link to="/">🏠 Home</router-link></li>
            <li><router-link to="/blog">📝 Blog</router-link></li>
            <li><router-link to="/settings">⚙️ Settings</router-link></li>
        </ul>
    </Sidebar>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from 'primevue/sidebar'

const sidebarVisible = ref(false)

const toggleSidebar = () => {
    sidebarVisible.value = !sidebarVisible.value
}
</script>