<template>
    <Layout>
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <!-- Article Header -->
            <ArticleHeader :title="article.title" :category="article.category"
                :publishedDate="new Date(article.created_at).toLocaleDateString()" />

            <!-- Article Content -->
            <ArticleContent :content="article.content" />

            <!-- Tags -->
            <TagsList :tags="article.tags" />

            <!-- Comments Section -->
            <CommentsList :comments="comments" />

            <!-- Add Comment Form -->
            <AddCommentForm />
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import Layout from '../../../components/Layout.vue';
import ArticleHeader from '../../../components/ArticleHeader.vue';
import ArticleContent from '../../../components/ArticleContent.vue';
import TagsList from '../../../components/TagsList.vue';
import CommentsList from '../../../components/CommentsList.vue';
import AddCommentForm from '../../../components/AddCommentForm.vue';

const router = useRouter();

// Data
const article = ref({});
const comments = ref([]);

// Fetch Article Data
const fetchArticleData = async (id) => {
    try {
        const response = await axios.get(`/api/articles/${id}`);
        article.value = response.data.article;
        comments.value = response.data.comments || [];
    } catch (error) {
        console.error('Error fetching article data:', error);
    }
};

// Fetch article when component is mounted
onMounted(() => {
    const articleId = router.currentRoute.value.params.id;
    fetchArticleData(articleId);
});
</script>

<style scoped>
/* Additional custom styles (if needed) */
</style>