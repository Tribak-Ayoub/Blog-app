<template>
    <Layout>
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Article</h1>
                <p class="text-gray-600">Share your knowledge and insights with the community.</p>
            </div>

            <!-- Success Message -->
            <div v-if="successMessage"
                class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-md flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 mt-0.5" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-green-800">Success</h3>
                    <p class="text-sm text-green-700 mt-1">{{ successMessage }}</p>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Form -->
                <form @submit.prevent="submitArticle" class="divide-y divide-gray-100">
                    <!-- Basic Info Section -->
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input id="title" v-model="form.title" type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                                placeholder="Enter a compelling title for your article" />
                            <p v-if="errors.title" class="mt-1.5 text-sm text-red-600">{{ errors.title[0] }}</p>
                        </div>

                        <!-- Category & Tags -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <div class="relative">
                                    <select id="category" v-model="form.category_id"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all appearance-none">
                                        <option value="" disabled>Select category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <p v-if="errors.category_id" class="mt-1.5 text-sm text-red-600">{{
                                    errors.category_id[0] }}</p>
                            </div>

                            <!-- Tags -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                                <div
                                    class="flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200 min-h-[42px]">
                                    <div v-for="tag in selectedTags" :key="tag.id"
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <span>{{ tag.name }}</span>
                                        <button type="button" @click="removeTag(tag.id)"
                                            class="ml-1.5 text-blue-600 hover:text-blue-800 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="relative">
                                        <select v-model="selectedTagId" @change="addTag"
                                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all appearance-none">
                                            <option value="" disabled>Add a tag</option>
                                            <option v-for="tag in availableTags" :key="tag.id" :value="tag.id">
                                                {{ tag.name }}
                                            </option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Article Content</h2>

                        <!-- Content Editor -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <TiptapEditor v-model="content" />
                            <p v-if="errors.content" class="mt-1.5 text-sm text-red-600">{{ errors.content[0] }}</p>
                        </div>
                    </div>

                    <!-- Media Section -->
                    <div class="p-6 space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Media</h2>

                        <!-- Featured Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                @click="triggerImageUpload">
                                <div class="space-y-1 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label
                                            class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input type="file" ref="imageInput" @change="handleImageChange" multiple
                                                class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>

                            <!-- Image Previews -->
                            <div v-if="form.images.length > 0" class="mt-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Selected Images</h3>
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                                    <div v-for="(image, index) in form.images" :key="index" class="relative group">
                                        <div
                                            class="h-24 w-full rounded-md bg-gray-100 overflow-hidden border border-gray-200">
                                            <img :src="URL.createObjectURL(image)" class="h-full w-full object-cover"
                                                :alt="`Selected image ${index + 1}`" />
                                        </div>
                                        <button type="button" @click="removeImage(index)"
                                            class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="p-6 bg-gray-50 flex items-center justify-between">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 text-sm font-medium transition-colors"
                            @click="saveDraft">
                            Save as Draft
                        </button>

                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors flex items-center justify-center disabled:opacity-70 disabled:cursor-not-allowed"
                            :disabled="loading">
                            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ loading ? 'Publishing...' : 'Publish Article' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Layout from "../../../components/Layout.vue";
import TiptapEditor from "../../../components/TiptapEditor.vue";

const router = useRouter();

// Form Data
const form = ref({
    title: "",
    content: "",
    category_id: "",
    tags: [],
    images: [],
    status: "published" // Default status
});

const content = ref(form.value.content);
watch(content, (val) => {
    form.value.content = val;
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
const selectedTagId = ref("");

// Image upload reference
const imageInput = ref(null);

// Computed properties
const selectedTags = computed(() => {
    return tags.value.filter(tag => form.value.tags.includes(tag.id));
});

const availableTags = computed(() => {
    return tags.value.filter(tag => !form.value.tags.includes(tag.id));
});

// Methods
const triggerImageUpload = () => {
    imageInput.value.click();
};

const handleImageChange = (event) => {
    const newImages = Array.from(event.target.files);
    form.value.images = [...form.value.images, ...newImages];
    // Reset the input to allow selecting the same file again
    event.target.value = null;
};

const removeImage = (index) => {
    form.value.images.splice(index, 1);
};

const addTag = () => {
    if (selectedTagId.value && !form.value.tags.includes(selectedTagId.value)) {
        form.value.tags.push(selectedTagId.value);
        selectedTagId.value = "";
    }
};

const removeTag = (tagId) => {
    form.value.tags = form.value.tags.filter(id => id !== tagId);
};

// Save as draft
const saveDraft = async () => {
    form.value.status = "draft";
    await submitArticle();
};

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
        const formData = new FormData();
        formData.append("title", form.value.title);
        formData.append("content", form.value.content);
        formData.append("category_id", form.value.category_id);
        formData.append("status", form.value.status);

        form.value.tags.forEach(tag => formData.append("tags[]", tag));
        form.value.images.forEach(image => formData.append("images[]", image));

        // Send form data
        await axios.post("/api/articles/store", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        // Show success message
        successMessage.value = form.value.status === "published"
            ? "Article published successfully!"
            : "Article saved as draft successfully!";

        // Redirect after 1.5 seconds
        setTimeout(() => router.push("/articles"), 1500);
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