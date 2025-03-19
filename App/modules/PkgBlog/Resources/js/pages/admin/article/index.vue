<template>
    <Layout>
        <div class="overflow-x-auto p-4">
            <table class="table table-zebra w-full border border-gray-200">
                <!-- Table Head -->
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Published At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-if="articles.length">
                    <tr v-for="(article, index) in articles" :key="article.id" class="hover:bg-gray-50">
                        <th>{{ index + 1 }}</th>
                        <td>{{ article.title }}</td>
                        <td>{{ article.author }}</td>
                        <td>{{ article.category }}</td>
                        <td>{{ formatDate(article.published_at) }}</td>
                        <td>
                            <router-link :to="`/articles/${article.id}`"
                                class="text-blue-500 hover:underline">View</router-link>
                            <router-link :to="`/articles/${article.id}/edit`"
                                class="text-yellow-500 hover:underline ml-2">Edit</router-link>
                            <button @click="deleteArticle(article.id)"
                                class="text-red-500 hover:underline ml-2">Delete</button>
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
    </Layout>
</template>

<script setup>
import Layout from "../../../components/Layout.vue";
import { ref, onMounted } from "vue";
import axios from "axios";

const articles = ref([]);

const fetchArticles = async () => {
    try {
        const response = await axios.get("/api/articles");
        articles.value = response.data;
    } catch (error) {
        console.error("Error fetching articles:", error);
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};

onMounted(fetchArticles);
</script>