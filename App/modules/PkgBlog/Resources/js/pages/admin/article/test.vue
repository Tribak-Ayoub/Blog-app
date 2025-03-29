<template>
    <div class="admin-article-container">
        <div class="admin-header">
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

            <div class="admin-actions">
                <div class="status-indicator"
                    :class="{ 'published': article.status === 'published', 'draft': article.status === 'draft' }">
                    {{ article.status === 'published' ? 'Published' : 'Draft' }}
                </div>

                <div class="action-buttons">
                    <button class="preview-button" @click="togglePreview">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        {{ isPreviewMode ? 'Exit Preview' : 'Preview' }}
                    </button>

                    <button class="save-button" @click="saveArticle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Save
                    </button>

                    <button class="publish-button" @click="togglePublishStatus"
                        :class="{ 'unpublish': article.status === 'published' }">
                        <svg v-if="article.status !== 'published'" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 3h-6l-2 4-2-4H6"></path>
                            <path d="M2 3h20v4H2z"></path>
                            <path d="M12 19l-2 3-2-3"></path>
                            <path d="M8 19h8"></path>
                            <path d="M12 7v8"></path>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                        </svg>
                        {{ article.status === 'published' ? 'Unpublish' : 'Publish' }}
                    </button>

                    <button class="delete-button" @click="confirmDelete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                            </path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <div v-if="showDeleteConfirm" class="delete-confirmation">
            <div class="delete-modal">
                <h3>Delete Article</h3>
                <p>Are you sure you want to delete this article? This action cannot be undone.</p>
                <div class="delete-actions">
                    <button class="cancel-button" @click="showDeleteConfirm = false">Cancel</button>
                    <button class="confirm-delete-button" @click="deleteArticle">Delete Article</button>
                </div>
            </div>
        </div>

        <div v-if="isPreviewMode" class="preview-mode">
            <div class="preview-header">
                <span class="preview-label">Preview Mode</span>
            </div>

            <!-- Preview content similar to public Show.vue -->
            <div class="article-preview">
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
                        <img v-if="section.image" :src="section.image.url" :alt="section.image.alt"
                            class="section-image" />
                    </div>

                    <div class="article-tags">
                        <span class="tag-label">Tags:</span>
                        <div class="tags-list">
                            <span v-for="(tag, index) in article.tags" :key="index" class="tag">{{ tag }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="edit-mode">
            <form @submit.prevent="saveArticle" class="article-form">
                <div class="form-section">
                    <h2 class="section-title">Basic Information</h2>

                    <div class="form-group">
                        <label for="title">Article Title</label>
                        <input type="text" id="title" v-model="article.title" class="form-control"
                            placeholder="Enter article title" required />
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" v-model="article.category" class="form-control" required>
                                <option value="">Select a category</option>
                                <option value="Technology">Technology</option>
                                <option value="Business">Business</option>
                                <option value="Design">Design</option>
                                <option value="Wellness">Wellness</option>
                                <option value="Food">Food</option>
                                <option value="Environment">Environment</option>
                                <option value="Innovation">Innovation</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="readTime">Read Time (minutes)</label>
                            <input type="number" id="readTime" v-model="article.readTime" class="form-control" min="1"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="date">Publication Date</label>
                            <input type="date" id="date" v-model="article.date" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lead">Lead Paragraph</label>
                        <textarea id="lead" v-model="article.lead" class="form-control" rows="3"
                            placeholder="Enter a compelling introduction paragraph" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Featured Image</label>
                        <div class="image-upload-container">
                            <div class="current-image" v-if="article.image">
                                <img :src="article.image" alt="Featured image" />
                                <button type="button" class="remove-image" @click="removeFeaturedImage">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="upload-controls" v-if="!article.image">
                                <label for="featured-image" class="upload-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <span>Upload Featured Image</span>
                                </label>
                                <input type="file" id="featured-image" class="file-input"
                                    @change="handleFeaturedImageUpload" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tags</label>
                        <div class="tags-input">
                            <div class="tags-container">
                                <span v-for="(tag, index) in article.tags" :key="index" class="tag-item">
                                    {{ tag }}
                                    <button type="button" class="remove-tag" @click="removeTag(index)">×</button>
                                </span>
                            </div>
                            <div class="tag-add">
                                <input type="text" v-model="newTag" @keyup.enter="addTag"
                                    placeholder="Add a tag and press Enter" class="tag-input" />
                                <button type="button" class="add-tag-btn" @click="addTag">Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Content Sections</h2>

                    <div v-for="(section, index) in article.content" :key="index" class="content-editor-section">
                        <div class="section-header">
                            <h3>Section {{ index + 1 }}</h3>
                            <button type="button" class="remove-section" @click="removeSection(index)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Remove Section
                            </button>
                        </div>

                        <div class="form-group">
                            <label :for="'section-heading-' + index">Section Heading</label>
                            <input type="text" :id="'section-heading-' + index" v-model="section.heading"
                                class="form-control" placeholder="Enter section heading" />
                        </div>

                        <div v-for="(paragraph, pIndex) in section.paragraphs" :key="pIndex" class="paragraph-editor">
                            <div class="form-group">
                                <label :for="'paragraph-' + index + '-' + pIndex">Paragraph {{ pIndex + 1 }}</label>
                                <div class="paragraph-actions">
                                    <button type="button" class="remove-paragraph"
                                        @click="removeParagraph(index, pIndex)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                <textarea :id="'paragraph-' + index + '-' + pIndex" v-model="section.paragraphs[pIndex]"
                                    class="form-control" rows="4" placeholder="Enter paragraph text"></textarea>
                            </div>
                        </div>

                        <button type="button" class="add-paragraph" @click="addParagraph(index)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Add Paragraph
                        </button>

                        <div class="form-group section-image-container">
                            <label>Section Image</label>
                            <div class="image-upload-container">
                                <div class="current-image" v-if="section.image && section.image.url">
                                    <img :src="section.image.url" :alt="section.image.alt" />
                                    <button type="button" class="remove-image" @click="removeSectionImage(index)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                <div class="upload-controls" v-if="!section.image || !section.image.url">
                                    <label :for="'section-image-' + index" class="upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                        <span>Upload Section Image</span>
                                    </label>
                                    <input type="file" :id="'section-image-' + index" class="file-input"
                                        @change="(e) => handleSectionImageUpload(e, index)" accept="image/*" />
                                </div>
                            </div>
                            <div class="form-group" v-if="section.image && section.image.url">
                                <label :for="'image-alt-' + index">Image Alt Text</label>
                                <input type="text" :id="'image-alt-' + index" v-model="section.image.alt"
                                    class="form-control" placeholder="Describe the image for accessibility" />
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-section" @click="addSection">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add New Section
                    </button>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Author Information</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="author-name">Author Name</label>
                            <input type="text" id="author-name" v-model="article.author.name" class="form-control"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="author-role">Author Role</label>
                            <input type="text" id="author-role" v-model="article.author.role" class="form-control"
                                required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="author-bio">Author Bio</label>
                        <textarea id="author-bio" v-model="article.author.bio" class="form-control" rows="3"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Author Avatar</label>
                        <div class="image-upload-container">
                            <div class="current-image avatar-preview" v-if="article.author.avatar">
                                <img :src="article.author.avatar" alt="Author avatar" />
                                <button type="button" class="remove-image" @click="removeAuthorAvatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="upload-controls" v-if="!article.author.avatar">
                                <label for="author-avatar" class="upload-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span>Upload Avatar</span>
                                </label>
                                <input type="file" id="author-avatar" class="file-input"
                                    @change="handleAuthorAvatarUpload" accept="image/*" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="cancel-button" @click="goBack">Cancel</button>
                    <button type="submit" class="save-button">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

// Toggle between edit and preview modes
const isPreviewMode = ref(false);
const showDeleteConfirm = ref(false);
const newTag = ref('');

// Sample article data
const article = reactive({
    id: 1,
    title: "The Future of Sustainable Technology",
    lead: "As we face unprecedented environmental challenges, the tech industry is pivoting towards more sustainable practices and innovations that could reshape our relationship with the planet.",
    image: "https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
    category: "Technology",
    date: "2023-11-15",
    readTime: 8,
    status: "published",
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
        }
    ],
    tags: ["Sustainability", "Green Tech", "Renewable Energy", "Circular Economy", "Innovation"]
});

// Format date to be more readable
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Navigation function
const goBack = () => {
    // In a real application, this would use Vue Router to navigate back
    console.log('Navigate back to articles list');
    // router.push('/admin/articles');
};

// Toggle preview mode
const togglePreview = () => {
    isPreviewMode.value = !isPreviewMode.value;
};

// Save article changes
const saveArticle = () => {
    // In a real application, this would send data to an API
    console.log('Saving article:', article);
    alert('Article saved successfully!');
};

// Toggle publish status
const togglePublishStatus = () => {
    article.status = article.status === 'published' ? 'draft' : 'published';
    console.log(`Article ${article.status === 'published' ? 'published' : 'unpublished'}`);
    alert(`Article ${article.status === 'published' ? 'published' : 'unpublished'} successfully!`);
};

// Delete confirmation
const confirmDelete = () => {
    showDeleteConfirm.value = true;
};

// Delete article
const deleteArticle = () => {
    // In a real application, this would send a delete request to an API
    console.log('Deleting article:', article.id);
    showDeleteConfirm.value = false;
    alert('Article deleted successfully!');
    goBack();
};

// Add a new tag
const addTag = () => {
    if (newTag.value.trim() && !article.tags.includes(newTag.value.trim())) {
        article.tags.push(newTag.value.trim());
        newTag.value = '';
    }
};

// Remove a tag
const removeTag = (index) => {
    article.tags.splice(index, 1);
};

// Add a new content section
const addSection = () => {
    article.content.push({
        heading: '',
        paragraphs: ['']
    });
};

// Remove a content section
const removeSection = (index) => {
    article.content.splice(index, 1);
};

// Add a paragraph to a section
const addParagraph = (sectionIndex) => {
    article.content[sectionIndex].paragraphs.push('');
};

// Remove a paragraph from a section
const removeParagraph = (sectionIndex, paragraphIndex) => {
    if (article.content[sectionIndex].paragraphs.length > 1) {
        article.content[sectionIndex].paragraphs.splice(paragraphIndex, 1);
    }
};

// Handle featured image upload
const handleFeaturedImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // In a real application, this would upload the file to a server
        // For demo purposes, we'll use a local URL
        const reader = new FileReader();
        reader.onload = (e) => {
            article.image = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Remove featured image
const removeFeaturedImage = () => {
    article.image = null;
};

// Handle section image upload
const handleSectionImageUpload = (event, sectionIndex) => {
    const file = event.target.files[0];
    if (file) {
        // In a real application, this would upload the file to a server
        // For demo purposes, we'll use a local URL
        const reader = new FileReader();
        reader.onload = (e) => {
            if (!article.content[sectionIndex].image) {
                article.content[sectionIndex].image = { url: '', alt: '' };
            }
            article.content[sectionIndex].image.url = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Remove section image
const removeSectionImage = (sectionIndex) => {
    article.content[sectionIndex].image = null;
};

// Handle author avatar upload
const handleAuthorAvatarUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // In a real application, this would upload the file to a server
        // For demo purposes, we'll use a local URL
        const reader = new FileReader();
        reader.onload = (e) => {
            article.author.avatar = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Remove author avatar
const removeAuthorAvatar = () => {
    article.author.avatar = null;
};
</script>

<style scoped>
.admin-article-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem 1rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    position: relative;
}

.admin-header {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (min-width: 768px) {
    .admin-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.breadcrumb {
    display: flex;
    align-items: center;
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

.admin-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}

.status-indicator {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-indicator.published {
    background-color: #dcfce7;
    color: #166534;
}

.status-indicator.draft {
    background-color: #f3f4f6;
    color: #4b5563;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.preview-button,
.save-button,
.publish-button,
.delete-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.preview-button {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.preview-button:hover {
    background-color: #e5e7eb;
}

.save-button {
    background-color: #2563eb;
    color: white;
    border: none;
}

.save-button:hover {
    background-color: #1d4ed8;
}

.publish-button {
    background-color: #059669;
    color: white;
    border: none;
}

.publish-button:hover {
    background-color: #047857;
}

.publish-button.unpublish {
    background-color: #f59e0b;
}

.publish-button.unpublish:hover {
    background-color: #d97706;
}

.delete-button {
    background-color: #ef4444;
    color: white;
    border: none;
}

.delete-button:hover {
    background-color: #dc2626;
}

.delete-confirmation {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
}

.delete-modal {
    background-color: white;
    padding: 2rem;
    border-radius: 8px;
    max-width: 500px;
    width: 90%;
}

.delete-modal h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.delete-modal p {
    margin-bottom: 1.5rem;
    color: #4b5563;
}

.delete-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.cancel-button {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
    font-weight: 500;
    cursor: pointer;
}

.confirm-delete-button {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    background-color: #ef4444;
    color: white;
    border: none;
    font-weight: 500;
    cursor: pointer;
}

/* Preview Mode Styles */
.preview-mode {
    position: relative;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

.preview-header {
    position: sticky;
    top: 0;
    background-color: #f9fafb;
    padding: 0.75rem 1rem;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: center;
    margin: -2rem -2rem 2rem -2rem;
    border-bottom: 1px solid #e5e7eb;
}

.preview-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4b5563;
}

/* Edit Mode Styles */
.article-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-section {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e5e7eb;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1rem;
}

@media (min-width: 640px) {
    .form-row {
        grid-template-columns: repeat(3, 1fr);
    }
}

label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.95rem;
    transition: border-color 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

textarea.form-control {
    resize: vertical;
}

.image-upload-container {
    border: 2px dashed #d1d5db;
    border-radius: 6px;
    padding: 1rem;
    text-align: center;
}

.current-image {
    position: relative;
    display: inline-block;
}

.current-image img {
    max-width: 100%;
    max-height: 300px;
    border-radius: 4px;
}

.avatar-preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
}

.remove-image {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background-color: rgba(255, 255, 255, 0.8);
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.remove-image:hover {
    background-color: rgba(255, 255, 255, 1);
}

.upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    padding: 1rem;
    color: #6b7280;
}

.upload-label:hover {
    color: #374151;
}

.file-input {
    display: none;
}

.tags-input {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background-color: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}

.remove-tag {
    background: none;
    border: none;
    font-size: 1rem;
    line-height: 1;
    cursor: pointer;
    color: #6b7280;
}

.tag-add {
    display: flex;
    gap: 0.5rem;
}

.tag-input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 0.875rem;
}

.add-tag-btn {
    padding: 0.5rem 1rem;
    background-color: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 0.875rem;
    cursor: pointer;
}

.content-editor-section {
    background-color: #f9fafb;
    border-radius: 6px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.section-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #374151;
}

.remove-section {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background: none;
    border: none;
    color: #ef4444;
    font-size: 0.875rem;
    cursor: pointer;
}

.paragraph-editor {
    position: relative;
    margin-bottom: 1rem;
}

.paragraph-actions {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    z-index: 1;
}

.remove-paragraph {
    background-color: rgba(255, 255, 255, 0.8);
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #ef4444;
}

.add-paragraph,
.add-section {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.75rem;
    background-color: #f3f4f6;
    border: 1px dashed #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    color: #4b5563;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.add-paragraph:hover,
.add-section:hover {
    background-color: #e5e7eb;
}

.section-image-container {
    margin-top: 1.5rem;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

/* Article Preview Styles */
.article-title {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1.2;
    color: #1a1a1a;
    margin-bottom: 1.5rem;
}

.article-meta {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
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
}

.article-featured-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
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
</style>