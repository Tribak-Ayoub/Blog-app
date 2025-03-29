<template>
    <div class="article-detail-container">
        <div class="article-header">
            <div class="breadcrumb">
                <button @click="goBack" class="back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon">
                        <path d="M19 12H5M12 19l-7-7 7-7"></path>
                    </svg>
                    Back to Articles
                </button>
            </div>

            <h1 class="article-title">{{ article.title }}</h1>

            <div class="article-meta">
                <div class="article-author">
                    <img :src="article.author.avatar" :alt="article.author.name" class="author-avatar" />
                    <div class="author-info">
                        <span class="author-name">{{ article.author.name }}</span>
                        <span class="author-role">{{ article.author.role }}</span>
                    </div>
                </div>

                <div class="article-info">
                    <span class="article-category">{{ article.category }}</span>
                    <span class="article-date">{{ formatDate(article.date) }}</span>
                    <span class="article-read-time">{{ article.readTime }} min read</span>
                </div>
            </div>
        </div>

        <div class="article-featured-image">
            <img :src="article.image" :alt="article.title" />
        </div>

        <div class="article-content">
            <p class="article-lead">{{ article.lead }}</p>

            <div v-for="(section, index) in article.content" :key="index" class="content-section">
                <h2 v-if="section.heading" class="section-heading">{{ section.heading }}</h2>
                <p v-for="(paragraph, pIndex) in section.paragraphs" :key="pIndex" class="paragraph">
                    {{ paragraph }}
                </p>
                <img v-if="section.image" :src="section.image.url" :alt="section.image.alt" class="section-image" />
            </div>

            <div class="article-tags">
                <span class="tag-label">Tags:</span>
                <div class="tags-list">
                    <span v-for="(tag, index) in article.tags" :key="index" class="tag">{{ tag }}</span>
                </div>
            </div>

            <div class="share-section">
                <span class="share-label">Share this article:</span>
                <div class="share-buttons">
                    <button class="share-button twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z">
                            </path>
                        </svg>
                    </button>
                    <button class="share-button facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </button>
                    <button class="share-button linkedin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                            </path>
                            <rect x="2" y="9" width="4" height="12"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </button>
                    <button class="share-button copy">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="author-bio">
            <img :src="article.author.avatar" :alt="article.author.name" class="author-avatar-large" />
            <div class="author-bio-content">
                <h3 class="author-name">About {{ article.author.name }}</h3>
                <p class="author-description">{{ article.author.bio }}</p>
            </div>
        </div>

        <div class="related-articles">
            <h2 class="related-title">Related Articles</h2>
            <div class="related-grid">
                <div v-for="(relatedArticle, index) in relatedArticles" :key="index" class="related-article-card">
                    <div class="related-image-container">
                        <img :src="relatedArticle.image" :alt="relatedArticle.title" class="related-image" />
                    </div>
                    <div class="related-content">
                        <span class="related-category">{{ relatedArticle.category }}</span>
                        <h3 class="related-article-title">{{ relatedArticle.title }}</h3>
                        <div class="related-meta">
                            <span class="related-date">{{ formatDate(relatedArticle.date) }}</span>
                            <span class="related-read-time">{{ relatedArticle.readTime }} min read</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// Sample article data
const article = ref({
    id: 1,
    title: "The Future of Sustainable Technology",
    lead: "As we face unprecedented environmental challenges, the tech industry is pivoting towards more sustainable practices and innovations that could reshape our relationship with the planet.",
    image: "https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
    category: "Technology",
    date: "2023-11-15",
    readTime: 8,
    author: {
        name: "Alex Morgan",
        role: "Technology Editor",
        avatar: "https://randomuser.me/api/portraits/women/44.jpg",
        bio: "Alex Morgan is a technology journalist with over 10 years of experience covering emerging tech trends and their impact on society. She holds a Master's degree in Environmental Science and is passionate about sustainable innovation."
    },
    content: [
        {
            heading: "The Growing Need for Sustainable Tech",
            paragraphs: [
                "Technology has transformed our lives in countless ways, but this progress has often come at an environmental cost. From e-waste to carbon emissions, the tech industry's footprint is substantial and growing.",
                "However, a new wave of innovation is emerging that places sustainability at its core. Companies are rethinking everything from materials and manufacturing to energy consumption and end-of-life disposal."
            ]
        },
        {
            heading: "Renewable Energy Integration",
            paragraphs: [
                "One of the most significant shifts has been the tech sector's embrace of renewable energy. Major companies like Apple, Google, and Microsoft have made commitments to power their operations with 100% renewable energy.",
                "This transition isn't just about corporate responsibility—it's increasingly making economic sense. The cost of solar and wind power has dropped dramatically, making renewable energy a competitive option for powering data centers and manufacturing facilities."
            ],
            image: {
                url: "https://images.unsplash.com/photo-1509391366360-2e959784a276?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80",
                alt: "Solar panels powering a modern data center"
            }
        },
        {
            heading: "Circular Design Principles",
            paragraphs: [
                "Beyond energy, companies are adopting circular design principles that consider the entire lifecycle of a product. This means designing devices that are easier to repair, upgrade, and eventually recycle.",
                "Modular smartphones, laptops with replaceable components, and programs that incentivize the return of old devices are all examples of this approach in action. These initiatives not only reduce waste but can create new business opportunities in refurbishment and materials recovery."
            ]
        },
        {
            heading: "The Road Ahead",
            paragraphs: [
                "While progress is being made, significant challenges remain. The demand for new devices continues to grow globally, and many sustainable technologies are still in their early stages of development.",
                "However, the combination of consumer pressure, regulatory requirements, and genuine innovation is creating momentum for change. The tech companies that thrive in the coming decades will likely be those that successfully balance cutting-edge innovation with environmental stewardship.",
                "As consumers, we also have a role to play—through the choices we make, the products we support, and the behaviors we adopt. The future of sustainable technology isn't just about what companies create, but how we choose to use it."
            ]
        }
    ],
    tags: ["Sustainability", "Green Tech", "Renewable Energy", "Circular Economy", "Innovation"]
});

// Sample related articles
const relatedArticles = ref([
    {
        id: 2,
        title: "How AI is Optimizing Energy Consumption",
        excerpt: "Artificial intelligence is revolutionizing how we manage and reduce energy use across industries.",
        image: "https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Technology",
        date: "2023-11-10",
        readTime: 6
    },
    {
        id: 3,
        title: "The Rise of Biodegradable Electronics",
        excerpt: "Researchers are developing electronic components that can safely decompose at end-of-life.",
        image: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Innovation",
        date: "2023-11-05",
        readTime: 5
    },
    {
        id: 4,
        title: "Corporate Sustainability: Beyond the Buzzwords",
        excerpt: "How tech companies are turning environmental commitments into meaningful action.",
        image: "https://images.unsplash.com/photo-1664575198308-3959904fa430?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
        category: "Business",
        date: "2023-11-12",
        readTime: 7
    }
]);

// Format date to be more readable
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Navigation function
const goBack = () => {
    router.back();
};
</script>

<style scoped>
.article-detail-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.article-header {
    margin-bottom: 2rem;
}

.breadcrumb {
    margin-bottom: 2rem;
}

.back-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: none;
    color: #555;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    padding: 0.5rem 0;
    transition: color 0.2s ease;
}

.back-button:hover {
    color: #000;
}

.icon {
    transition: transform 0.2s ease;
}

.back-button:hover .icon {
    transform: translateX(-3px);
}

.article-title {
    font-size: 2.75rem;
    font-weight: 800;
    line-height: 1.2;
    color: #1a1a1a;
    margin-bottom: 1.5rem;
}

.article-meta {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

@media (min-width: 640px) {
    .article-meta {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.article-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.author-info {
    display: flex;
    flex-direction: column;
}

.author-name {
    font-weight: 600;
    color: #1a1a1a;
}

.author-role {
    font-size: 0.875rem;
    color: #666;
}

.article-info {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.875rem;
    color: #666;
}

.article-category {
    background-color: #f3f4f6;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
    color: #374151;
}

.article-featured-image {
    margin: 2rem 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.article-featured-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
    aspect-ratio: 16/9;
}

.article-content {
    max-width: 800px;
    margin: 0 auto;
}

.article-lead {
    font-size: 1.25rem;
    line-height: 1.6;
    color: #444;
    margin-bottom: 2rem;
    font-weight: 500;
}

.content-section {
    margin-bottom: 2.5rem;
}

.section-heading {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 1.25rem;
}

.paragraph {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #333;
    margin-bottom: 1.25rem;
}

.section-image {
    width: 100%;
    border-radius: 8px;
    margin: 1.5rem 0;
}

.article-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin: 2rem 0;
    align-items: center;
}

.tag-label {
    font-weight: 600;
    color: #555;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag {
    background-color: #f3f4f6;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    color: #555;
}

.share-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin: 2rem 0;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
}

@media (min-width: 640px) {
    .share-section {
        flex-direction: row;
        align-items: center;
    }
}

.share-label {
    font-weight: 600;
    color: #555;
}

.share-buttons {
    display: flex;
    gap: 0.75rem;
}

.share-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.share-button:hover {
    transform: translateY(-2px);
}

.twitter {
    background-color: #1DA1F2;
    color: white;
}

.facebook {
    background-color: #4267B2;
    color: white;
}

.linkedin {
    background-color: #0077B5;
    color: white;
}

.copy {
    background-color: #e5e7eb;
    color: #374151;
}

.author-bio {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    background-color: #f9fafb;
    padding: 2rem;
    border-radius: 12px;
    margin: 3rem 0;
}

@media (min-width: 640px) {
    .author-bio {
        flex-direction: row;
    }
}

.author-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}

.author-bio-content {
    flex: 1;
}

.author-description {
    color: #555;
    line-height: 1.6;
}

.related-articles {
    margin-top: 4rem;
}

.related-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #1a1a1a;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.5rem;
}

@media (min-width: 640px) {
    .related-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .related-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.related-article-card {
    border-radius: 8px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.related-article-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.related-image-container {
    height: 160px;
    overflow: hidden;
}

.related-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.related-article-card:hover .related-image {
    transform: scale(1.05);
}

.related-content {
    padding: 1.25rem;
}

.related-category {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 0.5rem;
}

.related-article-title {
    font-size: 1.125rem;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 0.75rem;
    color: #1a1a1a;
}

.related-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #6b7280;
}
</style>