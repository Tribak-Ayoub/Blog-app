<template>
    <Layout>
        <div class="p-6 space-y-6">
            <!-- Header: Title + Create Button -->
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Articles</h2>
                <router-link :to="{ name: 'admin-article-create' }"
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
                        <tr class="bg-gray-200 text-gray-700 text-left">
                            <th class="py-2 px-4">#</th>
                            <th class="py-2 px-4">Title</th>
                            <th class="py-2 px-4">Author</th>
                            <th class="py-2 px-4">Category</th>
                            <th class="py-2 px-4">Created At</th>
                            <th class="py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="filteredArticles.length">
                        <tr v-for="(article, index) in filteredArticles" :key="article.id"
                            class="border-t hover:bg-gray-50 text-left">
                            <td class="py-2 px-4">{{ index + 1 }}</td>
                            <td class="py-2 px-4">{{ article.title }}</td>
                            <td class="py-2 px-4">{{ article.user.name }}</td>
                            <td class="py-2 px-4">{{ article.category.name }}</td>
                            <td class="py-2 px-4">{{ formatDate(article.created_at) }}</td>
                            <td class="py-2 px-4 space-x-2">
                                <router-link v-if="authStore.hasPermission('view article')"
                                    :to="{ name: 'admin-article-detail', params: { id: article.id } }"
                                    class="text-blue-500 hover:underline">
                                    View
                                </router-link>
                                <router-link
                                    v-if="authStore.hasPermission('edit article') && article.user_id === authStore.user.id"
                                    :to="{ name: 'admin-article-edit', params: { id: article.id } }"
                                    class="text-yellow-500 hover:underline">
                                    Edit
                                </router-link>
                                <button
                                    v-if="(authStore.hasPermission('delete article') && article.user_id === authStore.user.id) || authStore.hasRole('admin')"
                                    @click="deleteArticle(article.id)" class="text-red-500 hover:underline">
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
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const articles = ref([]);
const categories = ref([]);
const searchQuery = ref("");
const selectedCategory = ref("");

const fetchArticles = async () => {
    try {
        const response = await axios.get("/api/articles");
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
    if (authStore.hasRole('admin')) {
        return articles.value.filter(article => {
            const matchesSearch = article.title.toLowerCase().includes(searchQuery.value.toLowerCase());
            const matchesCategory = selectedCategory.value ? article.category_id == selectedCategory.value : true;
            return matchesSearch && matchesCategory;
        });
    }
    return articles.value.filter(article => {
        const matchesSearch = article.title.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesCategory = selectedCategory.value ? article.category_id == selectedCategory.value : true;
        const isOwner = article.user_id === authStore.user.id;
        return matchesSearch && matchesCategory && isOwner;
    });
});

const deleteArticle = async (articleId) => {
    if (confirm("Are you sure you want to delete this article?")) {
        try {
            const response = await axios.delete(`/api/articles/${articleId}`);

            // Remove the article from the list
            articles.value = articles.value.filter(article => article.id !== articleId);
        } catch (error) {
            console.error("Error deleting article:", error);
            alert("There was an error deleting the article. Please try again later.");
        }
    }
};

onMounted(fetchArticles);
</script>