<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation Bar -->
        <PublicNavbar :mobileMenuOpen="isMobileMenuOpen" @toggleMobileMenu="toggleMobileMenu" />

        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center min-h-screen">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="flex justify-center items-center min-h-screen">
            <div class="bg-white p-8 rounded-xl shadow-md max-w-md text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto mb-4" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Error Loading Article</h2>
                <p class="text-gray-600 mb-4">{{ error }}</p>
                <button @click="fetchArticle"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Try Again
                </button>
            </div>
        </div>

        <!-- Article Content -->
        <div v-else>
            <!-- Article Hero Section -->
            <div class="relative w-full h-[60vh] md:h-[70vh]">
                <div class="absolute inset-0 bg-cover bg-center"
                    :style="`background-image: url('${article.coverImage}')`">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/70 to-transparent"></div>
                </div>
                <div class="absolute inset-0 flex items-end">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-16 md:pb-24">
                        <div class="max-w-3xl">
                            <div class="flex items-center space-x-2 mb-4">
                                <span
                                    class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-semibold rounded-full">
                                    {{ article.category.name }}
                                </span>
                                <span class="text-white/80 text-sm">{{ formatDate(article.created_at) }}</span>
                            </div>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                                {{ article.title }}
                            </h1>
                            <div class="flex items-center">
                                <img :src="article.user.profile_image" :alt="article.user.name"
                                    class="w-10 h-10 rounded-full object-cover border-2 border-white" />
                                <div class="ml-3">
                                    <p class="text-white font-medium">{{ article.user.name }}</p>
                                    <div class="flex items-center text-white/70 text-sm">
                                        <!-- <span>{{ article.readingTime }} min read</span>
                                        <span class="mx-2">•</span> -->
                                        <span>{{ article.view_count }} views</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex flex-col lg:flex-row lg:space-x-12">
                    <!-- Main Content -->
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-xl shadow-sm p-6 md:p-10">
                            <!-- Article Body -->
                            <div class="prose prose-lg max-w-none">
                                <!-- <p class="text-xl text-gray-700 mb-8 leading-relaxed">
                                    {{ article.excerpt }}
                                </p> -->

                                <div v-html="article.content"></div>
                            </div>

                            <!-- Tags -->
                            <div class="mt-10 pt-8 border-t border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags</h3>
                                <div class="flex flex-wrap gap-2">
                                    <a v-for="(tag) in article.tags" :key="tag.id" href="#"
                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm text-gray-700 transition duration-200">
                                        {{ tag.name }}
                                    </a>
                                </div>
                            </div>

                            <!-- Share -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Share this article</h3>
                                <div class="flex space-x-4">
                                    <button @click="shareArticle('facebook')"
                                        class="p-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button @click="shareArticle('twitter')"
                                        class="p-2 bg-sky-500 text-white rounded-full hover:bg-sky-600 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button @click="shareArticle('linkedin')"
                                        class="p-2 bg-blue-800 text-white rounded-full hover:bg-blue-900 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                            </path>
                                            <rect x="2" y="9" width="4" height="12"></rect>
                                            <circle cx="4" cy="4" r="2"></circle>
                                        </svg>
                                    </button>
                                    <button @click="copyArticleLink"
                                        class="p-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                            <polyline points="16 6 12 2 8 6"></polyline>
                                            <line x1="12" y1="2" x2="12" y2="15"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Author Bio -->
                            <div class="mt-10 pt-8 border-t border-gray-200">
                                <div
                                    class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 bg-gray-50 p-6 rounded-xl">
                                    <img :src="article.user.profile_image" :alt="article.user.name"
                                        class="w-20 h-20 rounded-full object-cover border-2 border-white shadow-md" />
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">{{ article.user.name }}</h3>
                                        <p class="text-gray-600 mb-3">{{ article.user.role }}</p>
                                        <p class="text-gray-700">{{ article.user.bio }}</p>
                                        <div class="mt-4 flex space-x-3">
                                            <a :href="`/user/${article.user.id}`"
                                                class="text-blue-600 hover:text-blue-800 font-medium">Follow</a>
                                            <a :href="`/user/${article.user.id}/articles`"
                                                class="text-blue-600 hover:text-blue-800 font-medium">View all
                                                articles</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments -->
                            <div class="mt-10 pt-8 border-t border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">Comments ({{
                                    article.comments.length }})</h3>

                                <!-- Comment Form -->
                                <div class="mb-8">
                                    <div class="flex items-start space-x-4">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Your avatar"
                                            class="w-10 h-10 rounded-full object-cover" />
                                        <div class="flex-1">
                                            <textarea v-model="commentText" placeholder="Add a comment..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                rows="3"></textarea>
                                            <div class="mt-2 flex justify-end">
                                                <button @click="addComment" :disabled="commentSubmitting"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                                    <span v-if="commentSubmitting">Posting...</span>
                                                    <span v-else>Post Comment</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Comments List -->
                                <div v-if="article.comments.length > 0" class="space-y-6">
                                    <div v-for="(comment, index) in article.comments" :key="index"
                                        class="flex space-x-4">
                                        <img :src="comment.avatar" :alt="comment.name"
                                            class="w-10 h-10 rounded-full object-cover" />
                                        <div class="flex-1">
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="font-medium text-gray-900">{{ comment.name }}</h4>
                                                    <span class="text-sm text-gray-500">{{ formatDate(comment.date)
                                                    }}</span>
                                                </div>
                                                <p class="text-gray-700">{{ comment.text }}</p>
                                            </div>
                                            <div class="mt-2 ml-2 flex space-x-4 text-sm">
                                                <button class="text-gray-500 hover:text-blue-600">Reply</button>
                                                <button class="text-gray-500 hover:text-blue-600">Like</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- No Comments -->
                                <div v-else class="text-center py-8">
                                    <p class="text-gray-500">No comments yet. Be the first to share your thoughts!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-1/3 mt-10 lg:mt-0">
                        <!-- Newsletter -->
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Subscribe to our Newsletter</h3>
                            <p class="text-gray-600 mb-4">Get the latest articles and insights straight to your inbox.
                            </p>
                            <form @submit.prevent="subscribeToNewsletter" class="space-y-3">
                                <input type="email" v-model="emailInput" placeholder="Your email address"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required />
                                <button type="submit" :disabled="subscribeSubmitting"
                                    class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span v-if="subscribeSubmitting">Subscribing...</span>
                                    <span v-else>Subscribe</span>
                                </button>
                            </form>
                            <p class="mt-3 text-xs text-gray-500">We respect your privacy. Unsubscribe at any time.</p>
                        </div>

                        <!-- Related Articles -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Articles</h3>

                            <!-- Loading State for Related Articles -->
                            <div v-if="relatedLoading" class="py-8 flex justify-center">
                                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500">
                                </div>
                            </div>

                            <!-- Related Articles Content -->
                            <div v-else-if="relatedArticles.length > 0" class="space-y-6">
                                <div v-for="(relatedArticle, index) in relatedArticles" :key="index"
                                    class="flex space-x-4">
                                    <img :src="relatedArticle.image" :alt="relatedArticle.title"
                                        class="w-20 h-20 object-cover rounded-lg" />
                                    <div>
                                        <h4 class="font-medium text-gray-900 line-clamp-2 mb-1">
                                            <a :href="`/articles/${relatedArticle.id}`" class="hover:text-blue-600">{{
                                                relatedArticle.title }}</a>
                                        </h4>
                                        <p class="text-sm text-gray-500">{{ formatDate(relatedArticle.created_at) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- No Related Articles -->
                            <div v-else class="py-8 text-center">
                                <p class="text-gray-500">No related articles found.</p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                                <a href="/articles" class="text-blue-600 hover:text-blue-800 font-medium">View All
                                    Articles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <PublicFooter :currentYear="currentYear" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import PublicNavbar from '../../components/PublicNavbar.vue';
import PublicFooter from '../../components/PublicFooter.vue';

const route = useRoute();
const articleId = route.params.id;

// State variables
const article = ref({});
const relatedArticles = ref([]);
const loading = ref(true);
const relatedLoading = ref(true);
const error = ref(null);
const emailInput = ref('');
const commentText = ref('');
const commentSubmitting = ref(false);
const subscribeSubmitting = ref(false);

// Fetch article data
const fetchArticle = async () => {
    loading.value = true;
    relatedLoading.value = true;
    error.value = null;

    try {
        const response = await axios.get(`/api/articles/${articleId}`);
        article.value = response.data.article;
        relatedArticles.value = response.data.relatedArticles;
    } catch (err) {
        console.error('Error fetching article:', err);
        error.value = err.response?.data?.message || 'Failed to load article. Please try again later.';
    } finally {
        loading.value = false;
        relatedLoading.value = false;
    }
};

// Format date to be more readable
const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Newsletter subscription
const subscribeToNewsletter = async () => {
    if (subscribeSubmitting.value) return;

    subscribeSubmitting.value = true;
    try {
        await axios.post('/api/newsletter/subscribe', { email: emailInput.value });
        alert('Thank you for subscribing to our newsletter!');
        emailInput.value = '';
    } catch (err) {
        console.error('Error subscribing to newsletter:', err);
        alert(err.response?.data?.message || 'Failed to subscribe. Please try again later.');
    } finally {
        subscribeSubmitting.value = false;
    }
};

// Add comment
const addComment = async () => {
    if (commentSubmitting.value || commentText.value.trim() === '') return;

    commentSubmitting.value = true;
    try {
        const response = await axios.post(`/api/articles/${articleId}/comments`, {
            text: commentText.value
        });

        // Add the new comment to the list
        article.value.comments.unshift(response.data);
        commentText.value = '';
    } catch (err) {
        console.error('Error posting comment:', err);
        alert(err.response?.data?.message || 'Failed to post comment. Please try again later.');
    } finally {
        commentSubmitting.value = false;
    }
};

// Share article
const shareArticle = (platform) => {
    const url = window.location.href;
    const title = article.value.title;

    let shareUrl;

    switch (platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            break;
        default:
            return;
    }

    window.open(shareUrl, '_blank', 'width=600,height=400');
};

// Copy article link
const copyArticleLink = () => {
    const url = window.location.href;
    navigator.clipboard.writeText(url)
        .then(() => alert('Link copied to clipboard!'))
        .catch(err => console.error('Failed to copy link:', err));
};

// Fetch data when component mounts
onMounted(() => {
    fetchArticle();
});
</script>