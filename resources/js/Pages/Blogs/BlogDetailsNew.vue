<template>
    <div>
        <!-- LOADING STATE -->
        <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading blog...</p>
        </div>

        <!-- BLOG DETAILS -->
        <div v-else-if="blog" class="blog-details-container">
            <!-- HERO SECTION -->
            <section class="blog-hero" v-if="blog.image">
                <img :src="`/img/blogs/${blog.image}`"
                     :alt="blog.title"
                     class="hero-image"/>
            </section>

            <!-- CONTENT SECTION -->
            <section class="blog-content-section py-5">
                <div class="container">
                    <div class="row">
                        <!-- MAIN CONTENT -->
                        <div class="col-lg-8">
                            <!-- HEADER -->
                            <div class="content-header">
                                <!-- BREADCRUMB -->
                                <nav class="breadcrumb-nav" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="/blogs">All Blogs</a>
                                        </li>
                                        <li class="breadcrumb-item" v-if="blog.category">
                                            <a :href="`/blogs?category=${blog.category.id}`">
                                                {{ blog.category.title }}
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            {{ blog.title }}
                                        </li>
                                    </ol>
                                </nav>

                                <!-- BADGES -->
                                <div class="blog-badges">
                                    <span v-if="blog.category" class="badge-category">
                                        📂 {{ blog.category.title }}
                                    </span>
                                    <span v-if="blog.is_published" class="badge-published">
                                        ✓ Published
                                    </span>
                                </div>

                                <!-- TITLE -->
                                <h1 class="blog-title">{{ blog.title }}</h1>

                                <!-- META INFO -->
                                <div class="blog-meta-info">
                                    <div class="meta-item">
                                        <span class="icon">✍️</span>
                                        <div class="meta-text">
                                            <strong>Author</strong>
                                            <p>{{ blog.author }}</p>
                                        </div>
                                    </div>
                                    <div class="meta-item">
                                        <span class="icon">📅</span>
                                        <div class="meta-text">
                                            <strong>Published</strong>
                                            <p>{{ formatDate(blog.created_at) }}</p>
                                        </div>
                                    </div>
                                    <div class="meta-item" v-if="blog.updated_at && blog.updated_at !== blog.created_at">
                                        <span class="icon">🔄</span>
                                        <div class="meta-text">
                                            <strong>Updated</strong>
                                            <p>{{ formatDate(blog.updated_at) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DIVIDER -->
                            <hr class="content-divider">

                            <!-- BLOG CONTENT -->
                            <article class="blog-article">
                                <div v-html="blog.content" class="article-content"></div>
                            </article>

                            <!-- FOOTER -->
                            <div class="article-footer">
                                <div class="footer-divider"></div>
                                <div class="footer-content">
                                    <div class="author-info">
                                        <h5>About the Author</h5>
                                        <p>{{ blog.author }} is a contributor to Autours blog.</p>
                                    </div>
                                    <div class="share-buttons">
                                        <a href="#" class="share-btn facebook" title="Share on Facebook">
                                            <span>f</span>
                                        </a>
                                        <a href="#" class="share-btn twitter" title="Share on Twitter">
                                            <span>𝕏</span>
                                        </a>
                                        <a href="#" class="share-btn linkedin" title="Share on LinkedIn">
                                            <span>in</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SIDEBAR -->
                        <div class="col-lg-4">
                            <!-- RELATED BLOGS -->
                            <div class="sidebar-card">
                                <h5 class="sidebar-title">Related Articles</h5>
                                <div class="related-blogs">
                                    <div v-for="related in relatedBlogs"
                                         :key="related.id"
                                         class="related-blog-item"
                                         @click="openBlog(related.id)">
                                        <img v-if="related.image"
                                             :src="`/img/blogs/${related.image}`"
                                             :alt="related.title"
                                             class="related-image"/>
                                        <div class="related-content">
                                            <h6>{{ related.title }}</h6>
                                            <p>{{ formatDate(related.created_at) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CATEGORIES WIDGET -->
                            <div class="sidebar-card">
                                <h5 class="sidebar-title">Categories</h5>
                                <div class="categories-widget">
                                    <a v-for="category in categories"
                                       :key="category.id"
                                       href="#"
                                       class="category-link"
                                       @click.prevent="navigateToCategory(category.id)">
                                        <span class="cat-name">{{ category.title }}</span>
                                        <span class="cat-count">{{ category.blogs?.length || 0 }}</span>
                                    </a>
                                </div>
                            </div>

                            <!-- QUICK LINKS -->
                            <div class="sidebar-card">
                                <h5 class="sidebar-title">Navigation</h5>
                                <div class="quick-links">
                                    <a href="/blogs" class="quick-link">
                                        <span>← Back to Blogs</span>
                                    </a>
                                    <button @click="goToPrevious"
                                            :disabled="!previousBlog"
                                            class="quick-link">
                                        <span>← Previous Article</span>
                                    </button>
                                    <button @click="goToNext"
                                            :disabled="!nextBlog"
                                            class="quick-link">
                                        <span>Next Article →</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- RELATED BLOGS SECTION -->
            <section class="related-section py-5" v-if="relatedBlogs.length > 0">
                <div class="container">
                    <h3 class="section-title">More from {{ blog.category?.title || 'Our Blog' }}</h3>
                    <div class="row">
                        <div v-for="related in relatedBlogs.slice(0, 3)"
                             :key="related.id"
                             class="col-md-4">
                            <BlogCard :blog="related" @view-blog="openBlog"/>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- NOT FOUND STATE -->
        <div v-else class="not-found py-5 text-center">
            <div class="not-found-icon">📝</div>
            <h3>Blog Not Found</h3>
            <p>The blog you're looking for doesn't exist.</p>
            <a href="/blogs" class="btn btn-primary mt-3">Go Back to Blogs</a>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import BlogCard from './BlogCard.vue'

const route = useRoute()

const blog = ref(null)
const allBlogs = ref([])
const categories = ref([])
const loading = ref(true)

const blogId = computed(() => parseInt(route.params.id))

const relatedBlogs = computed(() => {
    if (!blog.value) return []
    return allBlogs.value.filter(b =>
        b.id !== blog.value.id &&
        b.blog_category_id === blog.value.blog_category_id &&
        b.is_published
    )
})

const previousBlog = computed(() => {
    const currentIndex = allBlogs.value.findIndex(b => b.id === blogId.value)
    return currentIndex > 0 ? allBlogs.value[currentIndex - 1] : null
})

const nextBlog = computed(() => {
    const currentIndex = allBlogs.value.findIndex(b => b.id === blogId.value)
    return currentIndex < allBlogs.value.length - 1 ? allBlogs.value[currentIndex + 1] : null
})

const formatDate = (date) => {
    if (!date) return 'Unknown'
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const fetchBlog = async () => {
    try {
        const res = await axios.get(`/api/blogs/${blogId.value}`)
        if (res.data.success) {
            blog.value = res.data.data
        }
    } catch (error) {
        console.error('Error fetching blog:', error)
    }
}

const fetchAllBlogs = async () => {
    try {
        const res = await axios.get('/api/blogs')
        if (res.data.success) {
            allBlogs.value = res.data.data.data || res.data.data
        }
    } catch (error) {
        console.error('Error fetching blogs:', error)
    }
}

const fetchCategories = async () => {
    try {
        const res = await axios.get('/api/blog-categories/active')
        if (res.data.success) {
            categories.value = res.data.data
        }
    } catch (error) {
        console.error('Error fetching categories:', error)
    }
}

const openBlog = (id) => {
    window.location.href = `/blogs/${id}`
}

const goToPrevious = () => {
    if (previousBlog.value) {
        openBlog(previousBlog.value.id)
    }
}

const goToNext = () => {
    if (nextBlog.value) {
        openBlog(nextBlog.value.id)
    }
}

const navigateToCategory = (categoryId) => {
    window.location.href = `/blogs?category=${categoryId}`
}

onMounted(async () => {
    await Promise.all([
        fetchBlog(),
        fetchAllBlogs(),
        fetchCategories()
    ])
    loading.value = false
})
</script>

<style scoped>
:root {
    --primary-color: #4096ee;
    --primary-dark: #1677DD;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --border-color: #e5e7eb;
    --secondary-bg: #f9fafb;
}

/* HERO SECTION */
.blog-hero {
    width: 100%;
    height: 400px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* CONTENT SECTION */
.blog-content-section {
    background: white;
}

.content-header {
    margin-bottom: 30px;
}

.breadcrumb-nav {
    margin-bottom: 15px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.blog-badges {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.badge-category,
.badge-published {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
}

.badge-category {
    background: var(--primary-color);
    color: white;
}

.badge-published {
    background: #d4edda;
    color: #155724;
}

.blog-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 20px;
    line-height: 1.3;
}

.blog-meta-info {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    padding: 15px 0;
}

.meta-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.meta-item .icon {
    font-size: 1.5rem;
}

.meta-text strong {
    display: block;
    font-size: 0.85rem;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.meta-text p {
    margin: 4px 0 0 0;
    font-size: 1rem;
    color: var(--text-dark);
    font-weight: 500;
}

.content-divider {
    border: none;
    border-top: 2px solid var(--border-color);
    margin: 30px 0;
}

/* ARTICLE CONTENT */
.blog-article {
    margin: 30px 0;
}

.article-content {
    font-size: 1.05rem;
    line-height: 1.8;
    color: var(--text-light);
}

.article-content :deep(p) {
    margin-bottom: 15px;
}

.article-content :deep(h2) {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 30px 0 15px;
}

.article-content :deep(h3) {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 25px 0 12px;
}

.article-content :deep(ul),
.article-content :deep(ol) {
    margin: 15px 0 15px 20px;
}

.article-content :deep(li) {
    margin-bottom: 8px;
}

.article-content :deep(blockquote) {
    border-left: 4px solid var(--primary-color);
    padding-left: 15px;
    margin: 20px 0;
    color: var(--text-dark);
    font-style: italic;
}

.article-content :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
}

.article-content :deep(a) {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.article-content :deep(a:hover) {
    text-decoration: underline;
}

/* ARTICLE FOOTER */
.article-footer {
    margin-top: 50px;
}

.footer-divider {
    height: 1px;
    background: var(--border-color);
    margin-bottom: 30px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.author-info h5 {
    margin-bottom: 8px;
    color: var(--text-dark);
}

.author-info p {
    color: var(--text-light);
    margin: 0;
}

.share-buttons {
    display: flex;
    gap: 10px;
}

.share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.share-btn.facebook {
    background: #1877f2;
}

.share-btn.twitter {
    background: #000;
}

.share-btn.linkedin {
    background: #0a66c2;
}

.share-btn:hover {
    transform: scale(1.1);
}

/* SIDEBAR */
.sidebar-card {
    background: var(--secondary-bg);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.sidebar-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 15px;
}

/* RELATED BLOGS */
.related-blogs {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.related-blog-item {
    display: flex;
    gap: 12px;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.related-blog-item:hover {
    background: white;
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.related-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    flex-shrink: 0;
}

.related-content {
    flex-grow: 1;
}

.related-content h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 4px;
    line-height: 1.3;
}

.related-content p {
    font-size: 0.8rem;
    color: var(--text-light);
    margin: 0;
}

/* CATEGORIES WIDGET */
.categories-widget {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.category-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 12px;
    background: white;
    border-radius: 6px;
    color: var(--text-dark);
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-link:hover {
    background: white;
    color: var(--primary-color);
    transform: translateX(5px);
}

.cat-name {
    font-weight: 500;
}

.cat-count {
    background: var(--primary-color);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* QUICK LINKS */
.quick-links {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.quick-link {
    padding: 10px 12px;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quick-link:hover:not(:disabled) {
    background: var(--primary-color);
    color: white;
}

.quick-link:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* RELATED SECTION */
.related-section {
    background: var(--secondary-bg);
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 30px;
    text-align: center;
}

/* NOT FOUND */
.not-found {
    text-align: center;
    color: var(--text-light);
}

.not-found-icon {
    font-size: 4rem;
    margin-bottom: 15px;
}

.not-found h3 {
    color: var(--text-dark);
    margin-bottom: 10px;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .blog-title {
        font-size: 2rem;
    }

    .blog-meta-info {
        flex-direction: column;
        gap: 15px;
    }

    .footer-content {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 768px) {
    .blog-hero {
        height: 250px;
    }

    .blog-title {
        font-size: 1.5rem;
    }

    .article-content {
        font-size: 1rem;
    }

    .article-content :deep(h2) {
        font-size: 1.3rem;
    }

    .article-content :deep(h3) {
        font-size: 1.1rem;
    }
}
</style>

