<template>
    <body>
    <div id="wrapper">
        <!-- header begin -->
        <header-one/>
        <!-- header close -->

        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>

            <!-- LOADING STATE -->
            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading article...</p>
            </div>

            <!-- BLOG DETAILS -->
            <div v-else-if="blog" class="blog-details-wrapper">
                <!-- HERO SECTION -->
                <section class="blog-hero-section" v-if="blog.image">
                    <img :src="`/img/blogs/${blog.image}`"
                         :alt="blog.title"
                         class="hero-image"/>
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        <div class="breadcrumb-hero">
                            <a href="/blogs">Blog</a> / <span>{{ blog.title.substring(0, 40) }}...</span>
                        </div>
                    </div>
                </section>

                <!-- MAIN CONTENT -->
                <section class="blog-content-wrapper py-5">
                    <div class="container">
                        <div class="row">
                            <!-- MAIN ARTICLE -->
                            <div class="col-lg-8">
                                <!-- ARTICLE HEADER -->
                                <article class="article-main">
                                    <header class="article-header">
                                        <h1 class="article-title">{{ blog.title }}</h1>

                                        <div class="article-meta">
                                            <div class="meta-item">
                                                <i class="fa fa-calendar"></i>
                                                <span>{{ formatDate(blog.created_at) }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fa fa-user"></i>
                                                <span>{{ blog.author }}</span>
                                            </div>
                                            <div class="meta-item" v-if="blog.category">
                                                <i class="fa fa-folder"></i>
                                                <span>{{ blog.category.title }}</span>
                                            </div>
                                        </div>

                                        <div class="article-divider"></div>
                                    </header>

                                    <!-- ARTICLE CONTENT -->
                                    <div class="article-body">
                                        <div v-html="blog.content" class="content-text"></div>
                                    </div>

                                    <!-- ARTICLE FOOTER -->
                                    <footer class="article-footer">
                                        <div class="author-box">
                                            <div class="author-avatar">
                                                <i class="fa fa-user-circle"></i>
                                            </div>
                                            <div class="author-info">
                                                <h5>About Author</h5>
                                                <p>{{ blog.author }} is a travel and automotive expert at Autours, sharing insights about global destinations and car rental solutions.</p>
                                            </div>
                                        </div>
                                    </footer>
                                </article>
                            </div>

                            <!-- SIDEBAR -->
                            <div class="col-lg-4">
                                <!-- RELATED POSTS -->
                                <div class="sidebar-widget" v-if="relatedBlogs.length > 0">
                                    <h5 class="widget-title">
                                        <i class="fa fa-link"></i> Related Articles
                                    </h5>
                                    <div class="related-posts-list">
                                        <div v-for="related in relatedBlogs.slice(0, 5)"
                                             :key="related.id"
                                             class="related-post"
                                             @click="openBlog(related.id)">
                                            <h6>{{ related.title }}</h6>
                                            <span class="related-date">{{ formatDate(related.created_at) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CATEGORIES -->
                                <div class="sidebar-widget" v-if="categories.length > 0">
                                    <h5 class="widget-title">
                                        <i class="fa fa-list"></i> Categories
                                    </h5>
                                    <div class="categories-list">
                                        <a v-for="category in categories"
                                           :key="category.id"
                                           href="#"
                                           class="category-link"
                                           @click.prevent="navigateToCategory(category.id)">
                                            <span>{{ category.title }}</span>
                                            <span class="count">{{ category.blogs?.length || 0 }}</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- QUICK NAVIGATION -->
                                <div class="sidebar-widget">
                                    <h5 class="widget-title">
                                        <i class="fa fa-compass"></i> Navigation
                                    </h5>
                                    <div class="nav-links">
                                        <a href="/blogs" class="nav-link">
                                            <i class="fa fa-arrow-left"></i> Back to Blog
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- RELATED SECTION -->
                <section class="related-articles-section py-5" v-if="relatedBlogs.length > 0">
                    <div class="container">
                        <h3 class="section-title">You May Also Like</h3>
                        <div class="row">
                            <div v-for="related in relatedBlogs.slice(0, 3)"
                                 :key="related.id"
                                 class="col-md-4 mb-4">
                                <div class="related-article-card" @click="openBlog(related.id)">
                                    <div class="card-image">
                                        <img v-if="related.image"
                                             :src="`/img/blogs/${related.image}`"
                                             :alt="related.title"/>
                                        <div v-else class="placeholder">
                                            <i class="fa fa-newspaper-o"></i>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <h5>{{ related.title }}</h5>
                                        <p>{{ getExcerpt(related.content, 80) }}</p>
                                        <span class="read-more">Read More →</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- NOT FOUND STATE -->
            <div v-else class="not-found-section">
                <div class="container text-center py-5">
                    <i class="fa fa-file-o"></i>
                    <h3>Article Not Found</h3>
                    <p>The article you're looking for doesn't exist or has been removed.</p>
                    <a href="/blogs" class="btn btn-primary">Go Back to Blog</a>
                </div>
            </div>
        </div>
        <!-- content close -->

        <!-- footer begin -->
        <footer-one/>
        <!-- footer close -->
    </div>
    </body>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import HeaderOne from '@/components/HeaderOne.vue'
import FooterOne from '@/components/Footer.vue'

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

const formatDate = (date) => {
    if (!date) return 'Unknown'
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const getExcerpt = (content, length = 80) => {
    if (!content) return 'No description available'
    const text = content.replace(/<[^>]*>/g, '')
    return text.length > length ? text.substring(0, length) + '...' : text
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
    --primary-color: #0066cc;
    --text-dark: #333333;
    --text-light: #666666;
    --border-color: #e0e0e0;
    --secondary-bg: #f9f9f9;
    --accent-color: #ffd100;
}

/* HERO SECTION */
.blog-hero-section {
    position: relative;
    height: 400px;
    overflow: hidden;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
}

.hero-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 30px;
    color: white;
}

.breadcrumb-hero {
    font-size: 1rem;
    opacity: 0.9;
}

/* CONTENT WRAPPER */
.blog-content-wrapper {
    background: white;
    padding: 60px 0;
}

/* ARTICLE */
.article-main {
    background: white;
}

.article-header {
    margin-bottom: 40px;
}

.article-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1.3;
    margin-bottom: 20px;
}

.article-meta {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    font-size: 0.95rem;
    color: var(--text-light);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.meta-item i {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.article-divider {
    height: 2px;
    background: var(--border-color);
    margin: 25px 0;
}

.article-body {
    margin: 30px 0;
}

.content-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-light);
}

.content-text :deep(p) {
    margin-bottom: 20px;
}

.content-text :deep(h2) {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 30px 0 15px;
}

.content-text :deep(h3) {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 25px 0 12px;
}

.content-text :deep(ul),
.content-text :deep(ol) {
    margin: 15px 0 15px 20px;
}

.content-text :deep(li) {
    margin-bottom: 10px;
}

.content-text :deep(blockquote) {
    border-left: 4px solid var(--primary-color);
    padding-left: 20px;
    margin: 20px 0;
    font-style: italic;
    color: var(--text-dark);
}

.content-text :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 25px 0;
}

.content-text :deep(a) {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.content-text :deep(a:hover) {
    text-decoration: underline;
}

/* ARTICLE FOOTER */
.article-footer {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid var(--border-color);
}

.author-box {
    display: flex;
    gap: 20px;
    background: var(--secondary-bg);
    padding: 25px;
    border-radius: 8px;
}

.author-avatar {
    flex-shrink: 0;
}

.author-avatar i {
    font-size: 3.5rem;
    color: var(--primary-color);
}

.author-info h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.author-info p {
    font-size: 0.95rem;
    color: var(--text-light);
    line-height: 1.6;
    margin: 0;
}

/* SIDEBAR WIDGETS */
.sidebar-widget {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 30px;
}

.widget-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--accent-color);
    display: flex;
    align-items: center;
    gap: 8px;
}

.widget-title i {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.related-posts-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.related-post {
    padding: 12px;
    background: var(--secondary-bg);
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.related-post:hover {
    background: #f0f0f0;
    border-left-color: var(--primary-color);
}

.related-post h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 5px;
    line-height: 1.3;
}

.related-date {
    font-size: 0.8rem;
    color: var(--text-light);
}

.categories-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.category-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: transparent;
    border: none;
    border-left: 3px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--text-dark);
    text-decoration: none;
    font-weight: 500;
}

.category-link:hover {
    background: var(--secondary-bg);
    border-left-color: var(--primary-color);
    color: var(--primary-color);
}

.category-link .count {
    background: var(--primary-color);
    color: white;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.nav-links {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 15px;
    background: var(--secondary-bg);
    border-radius: 6px;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: var(--primary-color);
    color: white;
}

/* RELATED ARTICLES SECTION */
.related-articles-section {
    background: var(--secondary-bg);
    border-top: 1px solid var(--border-color);
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    text-align: center;
    margin-bottom: 40px;
}

.related-article-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
}

.related-article-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: var(--primary-color);
}

.card-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: var(--secondary-bg);
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-article-card:hover .card-image img {
    transform: scale(1.05);
}

.placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    color: white;
    font-size: 2.5rem;
}

.card-content {
    padding: 20px;
}

.card-content h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 10px;
    line-height: 1.4;
}

.card-content p {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-bottom: 12px;
    line-height: 1.5;
}

.read-more {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-block;
}

.related-article-card:hover .read-more {
    color: #0052a3;
}

/* NOT FOUND SECTION */
.not-found-section {
    background: white;
}

.not-found-section i {
    font-size: 4rem;
    color: var(--text-light);
    margin-bottom: 20px;
}

.not-found-section h3 {
    font-size: 1.8rem;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.not-found-section p {
    color: var(--text-light);
    margin-bottom: 25px;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .article-title {
        font-size: 2rem;
    }

    .article-meta {
        flex-direction: column;
        gap: 10px;
    }

    .author-box {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .blog-hero-section {
        height: 250px;
    }

    .article-title {
        font-size: 1.5rem;
    }

    .content-text {
        font-size: 1rem;
    }

    .section-title {
        font-size: 1.5rem;
    }
}
</style>
