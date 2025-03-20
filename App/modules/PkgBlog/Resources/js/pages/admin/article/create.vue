<template>
    <Layout>
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Create New Article</h2>

            <!-- Success Message -->
            <p v-if="successMessage" class="text-green-600 mb-4">{{ successMessage }}</p>

            <!-- Form -->
            <form @submit.prevent="submitArticle">
                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-gray-700">Title</label>
                    <input v-model="form.title" type="text" class="w-full p-2 border rounded"
                        placeholder="Enter article title" />
                    <p v-if="errors.title" class="text-red-500 text-sm">{{ errors.title[0] }}</p>
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label class="block text-gray-700">Content</label>
                    <textarea v-model="form.content" class="w-full p-2 border rounded" rows="4"
                        placeholder="Enter article content"></textarea>
                    <p v-if="errors.content" class="text-red-500 text-sm">{{ errors.content[0] }}</p>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700">Category</label>
                    <select v-model="form.category_id" class="w-full p-2 border rounded">
                        <option value="" disabled>Select category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <p v-if="errors.category_id" class="text-red-500 text-sm">{{ errors.category_id[0] }}</p>
                </div>

                <!-- Tags (Multi-Select) -->
                <div class="mb-4">
                    <label class="block text-gray-700">Tags</label>
                    <div class="flex flex-wrap gap-2">
                        <label v-for="tag in tags" :key="tag.id" class="flex items-center space-x-2">
                            <input type="checkbox" v-model="form.tags" :value="tag.id" />
                            <span>{{ tag.name }}</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center gap-2"
                        :disabled="loading">
                        <span v-if="loading">Saving...</span>
                        <span v-else>Create Article</span>
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Layout from "../../../components/Layout.vue";

const router = useRouter();

// Form Data
const form = ref({
    title: "",
    content: "",
    category_id: "",
    tags: [] // Stores selected tag IDs
});

// Error Messages
const errors = ref({});

// Success Message
const successMessage = ref("");

// Loading State
const loading = ref(false);

// Categories & Tags
const categories = ref([]);
const tags = ref([]);

// Fetch Categories & Tags from API
const fetchData = async () => {
    try {
        const response = await axios.get("/api/articles/create");
        categories.value = response.data.categories;
        tags.value = response.data.tags;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

// Handle Form Submission
const submitArticle = async () => {
    loading.value = true;
    errors.value = {}; // Reset errors
    successMessage.value = ""; // Reset success message

    try {
        // Send form data
        await axios.post("/api/articles/store", {
            title: form.value.title,
            content: form.value.content,
            category_id: form.value.category_id,
            tags: form.value.tags // Ensure tags are sent as an array
        });

        // Show success message
        successMessage.value = "Article created successfully!";

        // Redirect after 1 second
        setTimeout(() => router.push("/articles"), 1000);
    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
    } finally {
        loading.value = false;
    }
};

onMounted(fetchData);
</script>
