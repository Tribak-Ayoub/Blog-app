<template>
    <Layout>
        <div class="p-6 space-y-6">
            <!-- Header: Title + Create Button -->
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Articles</h2>
                <router-link to="/articles/create"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    + Create Article
                </router-link>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-wrap items-center gap-4 bg-white p-4 rounded-lg shadow">
                <!-- Search Input -->
                <input v-model="searchQuery" type="text" placeholder="Search by title..."
                    class="border border-gray-300 p-2 rounded-lg w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <!-- Filter by Category -->
                <select v-model="selectedCategory"
                    class="border border-gray-300 p-2 rounded-lg w-full md:w-1/4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>

                <!-- Reset Filters -->
                <button @click="searchQuery = ''; selectedCategory = ''"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Reset
                </button>
            </div>

            <!-- Articles Table -->
            <div class="overflow-x-auto bg-white p-4 rounded-lg shadow">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-2 px-4">#</th>
                            <th class="py-2 px-4">Title</th>
                            <th class="py-2 px-4">Author</th>
                            <th class="py-2 px-4">Category</th>
                            <th class="py-2 px-4">Published At</th>
                            <th class="py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="filteredArticles.length">
                        <tr v-for="(article, index) in filteredArticles" :key="article.id"
                            class="border-t hover:bg-gray-50">
                            <td class="py-2 px-4">{{ index + 1 }}</td>
                            <td class="py-2 px-4">{{ article.title }}</td>
                            <td class="py-2 px-4">{{ article.user.name }}</td>
                            <td class="py-2 px-4">{{ article.category.name }}</td>
                            <td class="py-2 px-4">{{ formatDate(article.published_at) }}</td>
                            <td class="py-2 px-4 space-x-2">
                                <router-link :to="`/articles/${article.id}`" class="text-blue-500 hover:underline">
                                    View
                                </router-link>
                                <router-link :to="`/articles/${article.id}/edit`"
                                    class="text-yellow-500 hover:underline">
                                    Edit
                                </router-link>
                                <button @click="deleteArticle(article.id)" class="text-red-500 hover:underline">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6" class="text-center py-4">No articles found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../../components/Layout.vue";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const articles = ref([]);
const categories = ref([]);
const searchQuery = ref("");
const selectedCategory = ref("");

const fetchArticles = async () => {
    try {
        const response = await axios.get("/api/articles", { withCredentials: true });
        articles.value = response.data.articles.data;
        categories.value = response.data.categories;
    } catch (error) {
        console.error("Error fetching articles:", error);
    }
};

// Format the date
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};

// Computed property for filtering articles
const filteredArticles = computed(() => {
    return articles.value.filter(article => {
        const matchesSearch = article.title.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesCategory = selectedCategory.value ? article.category_id == selectedCategory.value : true;
        return matchesSearch && matchesCategory;
    });
});

onMounted(fetchArticles);
</script>