<template>
    <div class="articles-container">
        <header class="articles-header">
            <h1 class="page-title">Latest Articles</h1>
            <p class="page-description">Explore our collection of thought-provoking articles and stay informed</p>
        </header>

        <div class="articles-grid">
            <article v-for="article in filteredArticles" :key="article.id" class="article-card">
                <div class="article-image-container">
                    <img :src="article.image" :alt="article.title" class="article-image" />
                    <span class="article-category">{{ article.category }}</span>
                </div>
                <div class="article-content">
                    <h2 class="article-title">{{ article.title }}</h2>
                    <p class="article-excerpt">{{ article.title }}</p>
                    <div class="article-meta">
                        <div class="article-author">
                            <img :src="article.author || ''" :alt="article.author" class="author-avatar" />
                            <span>{{ article.author }}</span>
                        </div>
                        <time :datetime="article.date" class="article-date">{{ formatDate(article.date) }}</time>
                    </div>
                    <button class="read-more-btn">Read More</button>
                </div>
            </article>
        </div>

        <div class="pagination">
            <button class="pagination-btn" :disabled="currentPage === 1">&larr; Previous</button>
            <span class="page-indicator">Page {{ currentPage }} of {{ totalPages }}</span>
            <button class="pagination-btn" :disabled="currentPage === totalPages">Next &rarr;</button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const searchQuery = ref("");
const articles = ref([]);

// Fetch articles from the API
const fetchArticles = async () => {
    try {
        const response = await axios.get("/api/articles");
        articles.value = response.data.articles.data;
    } catch (error) {
        console.error("Error fetching articles:", error);
    }
};

// Filter articles based on the search query
const filteredArticles = computed(() => {
    return articles.value.filter(article => {
        return article.title.toLowerCase().includes(searchQuery.value.toLowerCase());
    });
});

const currentPage = ref(1);
const totalPages = ref(3);

// Format date to be more readable
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

onMounted(fetchArticles);
</script>

<style scoped>
.articles-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.articles-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.page-description {
    font-size: 1.125rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 2rem;
}

@media (min-width: 640px) {
    .articles-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .articles-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.article-card {
    border-radius: 12px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.article-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.article-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.article-card:hover .article-image {
    transform: scale(1.05);
}

.article-category {
    position: absolute;
    top: 12px;
    left: 12px;
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.article-content {
    padding: 1.5rem;
}

.article-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    color: #1a1a1a;
    line-height: 1.3;
}

.article-excerpt {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.article-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
}

.article-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #555;
}

.author-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
}

.article-date {
    color: #777;
}

.read-more-btn {
    display: block;
    width: 100%;
    padding: 0.75rem;
    background-color: #2d3748;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.read-more-btn:hover {
    background-color: #1a202c;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 3rem;
    gap: 1rem;
}

.pagination-btn {
    padding: 0.5rem 1rem;
    background-color: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    color: #374151;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.pagination-btn:hover:not(:disabled) {
    background-color: #e5e7eb;
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-indicator {
    color: #6b7280;
    font-size: 0.875rem;
}
</style>