<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-purple-50 p-6">
        <div class="max-w-4xl w-full bg-white p-8 rounded-xl shadow-2xl">
            <h2 class="text-4xl font-bold text-gray-900 mb-8">Edit Article</h2>

            <form @submit.prevent="submitForm" class="space-y-8">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-gray-700 font-semibold mb-3">Title</label>
                    <input v-model="article.title" type="text" id="title" placeholder="Enter article title"
                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 ease-in-out placeholder-gray-400"
                        required />
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-gray-700 font-semibold mb-3">Category</label>
                    <select v-model="article.category_id" id="category"
                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 ease-in-out"
                        required>
                        <option value="" disabled>Select a category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-gray-700 font-semibold mb-3">Content</label>
                    <textarea v-model="article.content" id="content" rows="8"
                        placeholder="Write your article content here..."
                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 ease-in-out placeholder-gray-400"
                        required></textarea>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-gray-700 font-semibold mb-3">Tags</label>
                    <input v-model="tagsInput" type="text" id="tags"
                        placeholder="Comma separated tags (e.g., Vue.js, TailwindCSS)"
                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 ease-in-out placeholder-gray-400" />
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-10 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 ease-in-out">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const article = ref({
    title: '',
    content: '',
    category_id: '',
});
const categories = ref([]);
const tagsInput = ref('');

// Fetch categories and article data
const fetchArticleData = async (id) => {
    try {
        const response = await axios.get(`/api/articles/${id}`);
        article.value = response.data.article;
        tagsInput.value = article.value.tags.map((tag) => tag.name).join(', ');
    } catch (error) {
        console.error('Error fetching article:', error);
    }
};

const fetchCategories = async () => {
    try {
        const response = await axios.get('/api/categories');
        categories.value = response.data.categories;
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
};

// Submit the updated article
const submitForm = async () => {
    const updatedArticle = {
        ...article.value,
        tags: tagsInput.value.split(',').map((tag) => tag.trim()), // Convert string to array of tags
    };

    try {
        await axios.put(`/api/articles/${article.value.id}`, updatedArticle);
        router.push(`/articles/${article.value.id}`);
    } catch (error) {
        console.error('Error updating article:', error);
    }
};

// Fetch data on mounted
onMounted(() => {
    const articleId = router.currentRoute.value.params.id;
    fetchArticleData(articleId);
    fetchCategories();
});
</script>

<style scoped>
/* Custom styles for inputs and textareas */
input,
textarea,
select {
    transition: all 0.2s ease-in-out;
}

input:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Button hover and focus states */
button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}

button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
</style>