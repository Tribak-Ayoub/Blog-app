<script setup>
import { defineProps, defineEmits } from 'vue';

defineProps(['mobileMenuOpen']);
const emit = defineEmits(['toggleMobileMenu']);
</script>

<template>
    <nav class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex-shrink-0">
                <a href="#" class="text-2xl font-extrabold text-gray-900 tracking-tight">Insights</a>
            </div>

            <div class="hidden md:block flex-1 max-w-md mx-8">
                <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Search articles..."
                        class="bg-transparent border-none w-full focus:outline-none text-sm" />
                </div>
            </div>

            <button class="lg:hidden flex items-center justify-center" @click="emit('toggleMobileMenu')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <div class="hidden lg:flex items-center justify-between flex-1">
                <div class="flex items-center space-x-8">
                    <a href="#" class="text-gray-900 font-medium">Home</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium">Articles</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium">Categories</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium">About</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-600 hover:text-gray-900 font-medium">Sign In</a>
                    <a href="#"
                        class="bg-gray-800 text-white px-5 py-2 rounded-full font-semibold hover:bg-gray-900 transition duration-200">Sign
                        Up</a>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div v-if="mobileMenuOpen" class="lg:hidden bg-white shadow-md py-4 px-4 absolute w-full">
            <div class="flex flex-col space-y-4">
                <a href="#" class="text-gray-900 font-medium py-2">Home</a>
                <a href="#" class="text-gray-500 hover:text-gray-900 font-medium py-2">Articles</a>
                <a href="#" class="text-gray-500 hover:text-gray-900 font-medium py-2">Categories</a>
                <a href="#" class="text-gray-500 hover:text-gray-900 font-medium py-2">About</a>
                <a href="#" class="text-gray-500 hover:text-gray-900 font-medium py-2">Contact</a>
                <div class="flex flex-col space-y-3 pt-3 border-t border-gray-200">
                    <a href="#" class="text-gray-600 hover:text-gray-900 font-medium">Sign In</a>
                    <a href="#"
                        class="bg-gray-800 text-white px-5 py-2 rounded-full font-semibold text-center hover:bg-gray-900 transition duration-200">Sign
                        Up</a>
                </div>
            </div>
        </div>
    </nav>
</template>