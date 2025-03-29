<template>
    <div class="font-sans text-gray-900">
        <!-- Navigation Bar -->
        <PublicNavbar :mobileMenuOpen="isMobileMenuOpen" @toggleMobileMenu="toggleMobileMenu" />

        <!-- Hero Section -->
        <HeroSection :featuredArticle="featuredArticle" :categories="categories" :popularTags="popularTags"
            :formatDate="formatDate" @subscribeToNewsletter="subscribeToNewsletter" />

        <!-- Featured Article -->
        <section class="bg-gray-50 pt-24 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Featured Article</h2>
                <div class="bg-white rounded-xl overflow-hidden shadow-lg flex flex-col md:flex-row">
                    <div class="md:w-1/2 relative">
                        <img :src="featuredArticle.image" :alt="featuredArticle.title"
                            class="w-full h-full object-cover" />
                        <span
                            class="absolute top-4 left-4 bg-gray-800 text-white px-4 py-1 rounded-full text-sm font-semibold">Featured</span>
                    </div>
                    <div class="md:w-1/2 p-8 flex flex-col">
                        <span
                            class="inline-block bg-gray-100 px-3 py-1 rounded-full text-sm font-medium text-gray-700 mb-4">{{
                                featuredArticle.category }}</span>
                        <h3 class="text-2xl font-bold mb-4">{{ featuredArticle.title }}</h3>
                        <p class="text-gray-600 mb-6 flex-grow">{{ featuredArticle.excerpt }}</p>
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center space-x-3">
                                <img :src="featuredArticle.author.avatar" :alt="featuredArticle.author.name"
                                    class="w-10 h-10 rounded-full object-cover" />
                                <span class="font-medium">{{ featuredArticle.author.name }}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span>{{ formatDate(featuredArticle.date) }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ featuredArticle.readTime }} min read</span>
                            </div>
                        </div>
                        <button
                            class="bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-900 transition duration-200 self-start">Read
                            Article</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-10">Explore Topics</h2>
                <div class="flex flex-wrap justify-center gap-3">
                    <button v-for="category in categories" :key="category.id"
                        class="px-5 py-2 rounded-full text-sm font-medium transition duration-200"
                        :class="selectedCategory === category.id ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        @click="filterByCategory(category.id)">
                        {{ category.name }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Recent Articles -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold">Recent Articles</h2>
                    <button class="text-gray-800 font-semibold hover:underline">View All</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article v-for="article in filteredArticles" :key="article.id"
                        class="bg-white rounded-xl overflow-hidden shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="relative h-48">
                            <img :src="article.image" :alt="article.title" class="w-full h-full object-cover" />
                            <span
                                class="absolute top-4 left-4 bg-gray-100 px-3 py-1 rounded-full text-xs font-medium text-gray-700">{{
                                    article.category }}</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 line-clamp-2">{{ article.title }}</h3>
                            <p class="text-gray-600 mb-6 line-clamp-3">{{ article.excerpt }}</p>
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center space-x-2">
                                    <img :src="article.author.avatar" :alt="article.author.name"
                                        class="w-8 h-8 rounded-full object-cover" />
                                    <span class="text-sm font-medium">{{ article.author.name }}</span>
                                </div>
                                <time :datetime="article.date" class="text-xs text-gray-500">{{ formatDate(article.date)
                                }}</time>
                            </div>
                            <button
                                class="w-full bg-gray-800 text-white py-3 rounded-lg font-medium hover:bg-gray-900 transition duration-200">Read
                                More</button>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <Newsletter v-model="emailInput" @subscribeToNewsletter="subscribeToNewsletter" />

        <!-- Popular Tags -->
        <PopularTags :popularTags="popularTags" />

        <!-- Footer -->
        <PublicFooter :currentYear="currentYear" />

    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import PublicNavbar from '../../components/PublicNavbar.vue';
import HeroSection from '../../components/HeroSection.vue';
import Newsletter from '../../components/Newsletter.vue';
import PopularTags from '../../components/PopularTags.vue';
import PublicFooter from '../../components/PublicFooter.vue';

// Mobile menu state
const isMobileMenuOpen = ref(false);

// Toggle mobile menu
const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

// Email input for newsletter
const emailInput = ref('');

// Selected category for filtering
const selectedCategory = ref(null);

// Featured article
const featuredArticle = ref({
    id: 1,
    title: "The Future of Sustainable Technology",
    excerpt: "As we face unprecedented environmental challenges, the tech industry is pivoting towards more sustainable practices and innovations that could reshape our relationship with the planet.",
    image: "https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
    category: "Technology",
    date: "2023-11-15",
    readTime: 8,
    author: {
        name: "Alex Morgan",
        avatar: "https://randomuser.me/api/portraits/women/44.jpg"
    }
});

// Categories
const categories = ref([
    { id: null, name: "All" },
    { id: "technology", name: "Technology" },
    { id: "business", name: "Business" },
    { id: "design", name: "Design" },
    { id: "wellness", name: "Wellness" },
    { id: "environment", name: "Environment" }
]);

// Popular tags
const popularTags = ref([
    "Sustainability",
    "Innovation",
    "AI",
    "Climate Change",
    "Mental Health",
    "Remote Work",
    "UX Design",
    "Startups",
    "Productivity"
]);

// Recent articles
const articles = ref([
    {
        id: 2,
        title: "How AI is Optimizing Energy Consumption",
        excerpt: "Artificial intelligence is revolutionizing how we manage and reduce energy use across industries.",
        image: "https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Technology",
        date: "2023-11-10",
        author: {
            name: "Jamie Chen",
            avatar: "https://randomuser.me/api/portraits/men/32.jpg"
        }
    },
    {
        id: 3,
        title: "The Art of Modern Architecture",
        excerpt: "Examining how contemporary architects are blending functionality, sustainability, and aesthetic appeal.",
        image: "https://images.unsplash.com/photo-1511818966892-d7d671e672a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Design",
        date: "2023-11-05",
        author: {
            name: "Taylor Reed",
            avatar: "https://randomuser.me/api/portraits/women/67.jpg"
        }
    },
    {
        id: 4,
        title: "Global Cuisine: A Journey Through Flavors",
        excerpt: "Discover the rich tapestry of international cuisines and their cultural significance around the world.",
        image: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Wellness",
        date: "2023-10-28",
        author: {
            name: "Sam Johnson",
            avatar: "https://randomuser.me/api/portraits/men/22.jpg"
        }
    },
    {
        id: 5,
        title: "The Evolution of Remote Work",
        excerpt: "How the pandemic transformed workplace norms and what the future holds for distributed teams.",
        image: "https://images.unsplash.com/photo-1593642634402-b0eb5e2eebc9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Business",
        date: "2023-10-20",
        author: {
            name: "Jordan Smith",
            avatar: "https://randomuser.me/api/portraits/women/17.jpg"
        }
    },
    {
        id: 6,
        title: "Exploring the Depths: Ocean Conservation",
        excerpt: "The importance of preserving marine ecosystems and the innovative approaches being developed.",
        image: "https://images.unsplash.com/photo-1551244072-5d12893278ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Environment",
        date: "2023-10-15",
        author: {
            name: "Riley Cooper",
            avatar: "https://randomuser.me/api/portraits/men/54.jpg"
        }
    },
    {
        id: 7,
        title: "Mindfulness in the Digital Age",
        excerpt: "How to maintain mental wellness and focus in an era of constant notifications and digital distractions.",
        image: "https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Wellness",
        date: "2023-10-10",
        author: {
            name: "Casey Morgan",
            avatar: "https://randomuser.me/api/portraits/women/23.jpg"
        }
    }
]);

// Filter articles by category
const filteredArticles = computed(() => {
    if (!selectedCategory.value) {
        return articles.value;
    }

    return articles.value.filter(article =>
        article.category.toLowerCase() === selectedCategory.value
    );
});

// Format date to be more readable
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Filter by category
const filterByCategory = (categoryId) => {
    selectedCategory.value = categoryId;
};

// Newsletter subscription
const subscribeToNewsletter = () => {
    // In a real application, this would send the email to an API
    console.log('Subscribing email:', emailInput.value);
    alert(`Thank you for subscribing with ${emailInput.value}!`);
    emailInput.value = '';
};

const currentYear = computed(() => new Date().getFullYear());
</script>