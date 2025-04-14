<template>
    <nav class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <router-link :to="{ name: 'home' }" class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    Insights
                </router-link>
            </div>

            <!-- Search -->
            <div class="hidden md:block flex-1 max-w-md mx-8">
                <div class="flex items-center bg-gray-100 rounded-full px-4 py-1">
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

            <!-- Hamburger Button -->
            <button class="lg:hidden flex items-center justify-center" @click="emit('toggleMobileMenu')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center justify-between flex-1">
                <div class="flex items-center space-x-8 relative">
                    <router-link :to="{ name: 'home' }"
                        :class="[route.name === 'home' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                        Home
                    </router-link>

                    <router-link :to="{ name: 'articles' }"
                        :class="[route.name === 'articles' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                        Articles
                    </router-link>

                    <!-- Categories Dropdown -->
                    <div class="relative">
                        <button @click="showCategoryDropdown = !showCategoryDropdown"
                            class="text-gray-500 hover:text-gray-900 font-medium flex items-center gap-1">
                            Categories
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div v-if="showCategoryDropdown"
                            class="absolute top-full mt-2 w-48 bg-white border rounded shadow-md z-50">
                            <router-link v-for="category in categories" :key="category.id"
                                :to="{ name: 'articles', query: { category: category.id } }"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                {{ category.name }}
                            </router-link>
                        </div>
                    </div>

                    <router-link to="/about"
                        :class="[route.path === '/about' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                        About
                    </router-link>
                    <router-link to="/contact"
                        :class="[route.path === '/contact' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                        Contact
                    </router-link>
                </div>

                <!-- User Section -->
                <div class="flex items-center space-x-4">
                    <!-- Show login/signup buttons if user is not logged in -->
                    <div v-if="!authStore.isLoggedIn">
                        <a href="/login" class="text-gray-600 hover:text-gray-900 font-medium">Sign
                            In</a>
                        <a href="/register"
                            class="bg-gray-800 text-white ms-2 px-5 py-2 rounded-full font-semibold hover:bg-gray-900 transition duration-200">
                            Sign Up
                        </a>
                    </div>

                    <!-- Show profile image and logout if user is logged in -->
                    <div v-else>
                        <div class="relative">
                            <button @click="toggleDropdown" class="flex items-center cursor-pointer">
                                <img v-if="authStore.user" :src="authStore.user.profile_image"
                                    :alt="authStore.user.name || 'User'" class="w-8 h-8 rounded-full" />
                            </button>
                            <!-- Dropdown -->
                            <ul v-show="isDropdownOpen"
                                class="absolute right-0 top-full transform translate-y-2 w-52 bg-white text-gray-900 shadow-lg rounded-lg p-2 z-50">
                                <li class="block border-b-2 px-4 py-2">
                                    <p class="text-sm font-semibold">{{ authStore.user.name }}</p>
                                </li>
                                <li>
                                    <a href="/profile" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                                </li>
                                <li>
                                    <button @click="logout" class="block w-full text-left px-4 py-2 hover:bg-gray-200">
                                        Log Out
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="mobileMenuOpen" class="lg:hidden bg-white shadow-md py-4 px-4 absolute w-full">
            <div class="flex flex-col space-y-4">
                <router-link :to="{ name: 'home' }"
                    :class="[route.name === 'home' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                    Home
                </router-link>
                <router-link :to="{ name: 'articles' }"
                    :class="[route.name === 'articles' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                    Articles
                </router-link>
                <div class="text-gray-500 hover:text-gray-900 font-medium py-2">
                    Categories
                    <div class="pl-4">
                        <router-link v-for="category in categories" :key="category.id"
                            :to="{ name: 'articles', query: { category: category.id } }"
                            class="block text-sm py-1 hover:underline">
                            {{ category.name }}
                        </router-link>
                    </div>
                </div>
                <router-link to="/about"
                    :class="[route.path === '/about' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                    About
                </router-link>
                <router-link to="/contact"
                    :class="[route.path === '/contact' ? 'text-gray-900 font-semibold' : 'text-gray-500 hover:text-gray-900 font-medium']">
                    Contact
                </router-link>

                <!-- Mobile Login/Signup Section -->
                <div v-if="!authStore.isLoggedIn" class="flex flex-col space-y-3 pt-3 border-t border-gray-200">
                    <a href="/login" class="text-gray-600 hover:text-gray-900 font-medium">Sign In</a>
                    <a href="/register"
                        class="bg-gray-800 text-white px-5 py-2 rounded-full font-semibold text-center hover:bg-gray-900 transition duration-200">
                        Sign Up
                    </a>
                </div>

                <!-- Mobile Profile Section -->
                <div v-else class="flex flex-col space-y-3 pt-3 border-t border-gray-200">
                    <span class="text-gray-600">Hello, {{ authStore.user.name }}</span>
                    <a href="/profile" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                    <button @click="authStore.logout"
                        class="border-t text-gray-600 hover:text-gray-900 font-medium text-left">Logout</button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth'

defineProps(['mobileMenuOpen']);
const emit = defineEmits(['toggleMobileMenu']);
const authStore = useAuthStore()

const route = useRoute();
const showCategoryDropdown = ref(false);
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const logout = async () => {
    try {
        await axios.post('/logout');
        authStore.logout(); // Call the logout method from the auth store
        window.location.href = '/'; // Redirect to home page after logout
    } catch (error) {
        console.error('Logout failed:', error);
    }
};

const categories = [
    { id: 1, name: 'Tech' },
    { id: 2, name: 'Design' },
    { id: 3, name: 'Business' }
];
</script>
