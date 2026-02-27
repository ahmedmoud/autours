<template>
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
                    <div class="hero-content">
                        <div class="breadcrumb-hero">
                            <a href="/blogs">🏠 Blog</a> /
                            <span>{{ blog.title.substring(0, 50) }}{{ blog.title.length > 50 ? '...' : '' }}</span>
                        </div>
                    </div>
                </section>

                <!-- MAIN CONTENT -->
                <section class="blog-content-wrapper py-5">
                    <div class="container-lg">
                        <div class="row">
                            <!-- MAIN ARTICLE -->
                            <div class="col-lg-8">
                                <!-- ARTICLE HEADER -->
                                <article class="article-main">
                                    <header class="article-header">
                                        <div class="header-top">
                                            <h1 class="article-title">{{ blog.title }}</h1>
                                        </div>

                                        <div class="article-meta">
                                            <div class="meta-item">
                                                <i class="fa fa-calendar"></i>
                                                <span class="meta-text">{{ formatDate(blog.created_at) }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fa fa-user"></i>
                                                <span class="meta-text">By {{ blog.author }}</span>
                                            </div>
                                            <div class="meta-item" v-if="blog.category">
                                                <i class="fa fa-folder-open"></i>
                                                <span class="meta-text">{{ blog.category.title }}</span>
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
                                                <h5>✍️ About the Author</h5>
                                                <p>{{ blog.author }} is a travel and automotive expert at Autours, sharing valuable insights about global destinations and car rental solutions to help travelers make informed decisions.</p>
                                            </div>
                                        </div>
                                    </footer>
                                </article>
                            </div>

                            <!-- SIDEBAR -->
                            <div class="col-lg-4">
                                <!-- NAVIGATION WIDGET -->
                                <div class="sidebar-widget">
                                    <h5 class="widget-title">
                                        <i class="fa fa-compass"></i> Quick Navigation
                                    </h5>
                                    <div class="nav-links">
                                        <a href="/blogs" class="nav-link">
                                            <i class="fa fa-arrow-left"></i> Back to All Articles
                                        </a>
                                    </div>
                                </div>

                                <!-- ARTICLE INFO WIDGET -->
                                <div class="sidebar-widget">
                                    <h5 class="widget-title">
                                        <i class="fa fa-info-circle"></i> Article Information
                                    </h5>
                                    <div style="display: flex; flex-direction: column; gap: 12px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <i class="fa fa-user" style="color: var(--primary-color); width: 20px;"></i>
                                            <span style="color: var(--text-light); font-size: 0.9rem;">{{ blog.author }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <i class="fa fa-calendar" style="color: var(--primary-color); width: 20px;"></i>
                                            <span style="color: var(--text-light); font-size: 0.9rem;">{{ formatDate(blog.created_at) }}</span>
                                        </div>
                                        <div v-if="blog.category" style="display: flex; align-items: center; gap: 10px;">
                                            <i class="fa fa-folder-open" style="color: var(--primary-color); width: 20px;"></i>
                                            <span style="color: var(--text-light); font-size: 0.9rem;">{{ blog.category.title }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CATEGORIES WIDGET -->
                                <div class="sidebar-widget" v-if="categories.length > 0">
                                    <h5 class="widget-title">
                                        <i class="fa fa-list"></i> All Categories
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

                                <!-- RELATED POSTS WIDGET -->
                                <div class="sidebar-widget" v-if="relatedBlogs.length > 0">
                                    <h5 class="widget-title">
                                        <i class="fa fa-link"></i> Related Reading
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
                                             :alt="related.title"
                                             loading="lazy"/>
                                        <div v-else class="placeholder">
                                            <i class="fa fa-newspaper-o"></i>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <h5>{{ related.title }}</h5>
                                        <p>{{ getExcerpt(related.content, 80) }}</p>
                                        <span class="read-more">
                                            <i class="fa fa-arrow-right"></i> Read More
                                        </span>
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
        <!-- footer close -->
    </div>
    <footer-one/>

</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import HeaderOne from '@/components/HeaderOne.vue'
import FooterOne from '@/components/Footer.vue'

const page = usePage()

const blog = ref(null)
const allBlogs = ref([])
const categories = ref([])
const loading = ref(true)

// ... define functions first ...
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
    if (!blogId.value) {
        console.error('Blog ID not found', {
            ziggyParams: page.props.ziggy?.params,
            pathname: window.location.pathname
        })
        loading.value = false
        return
    }

    try {
        console.log('Fetching blog with ID:', blogId.value)
        const res = await axios.get(`/api/blogs/${blogId.value}`)
        if (res.data.success) {
            blog.value = res.data.data
            console.log('Blog fetched successfully:', blog.value)
        } else {
            console.error('API returned success: false', res.data)
        }
    } catch (error) {
        console.error('Error fetching blog:', error)
        blog.value = null
    } finally {
        loading.value = false
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
        const res = await axios.get('/api/blog-categories')
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

// Get blog ID from route params - try multiple approaches
const blogId = computed(() => {
    // Try ziggy params first
    if (page.props.ziggy?.params?.id) {
        return parseInt(page.props.ziggy.params.id)
    }

    // Try from URL directly
    const urlParts = window.location.pathname.split('/')
    const id = parseInt(urlParts[urlParts.length - 1])
    if (!isNaN(id)) {
        return id
    }

    return null
})

// Watch for blog ID changes and fetch when it's available (NOW fetchBlog is defined)
watch(() => blogId.value, (newId) => {
    if (newId) {
        fetchBlog()
    }
}, { immediate: true })

const relatedBlogs = computed(() => {
    if (!blog.value) return []
    return allBlogs.value.filter(b =>
        b.id !== blog.value.id &&
        b.blog_category_id === blog.value.blog_category_id &&
        b.is_published
    )
})

onMounted(async () => {
    await Promise.all([
        fetchAllBlogs(),
        fetchCategories()
    ])

    // Fetch blog if ID is available
    if (blogId.value) {
        await fetchBlog()
    } else {
        loading.value = false
    }
})
</script>

<style scoped>
/* HERO SECTION */
.blog-hero-section {
    position: relative;
    height: 500px;
    overflow: hidden;
    background: linear-gradient(135deg, #ffd100 0%, #f0c000 100%);
    margin-bottom: 0;
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
    background: rgba(0, 0, 0, 0.3);
}

.hero-content {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    padding: 30px 40px;
    color: white;
    z-index: 10;
}

.breadcrumb-hero {
    font-size: 0.95rem;
    opacity: 0.95;
    font-weight: 500;
}

.breadcrumb-hero a {
    color: white;
    text-decoration: none;
    transition: opacity 0.3s ease;
}

.breadcrumb-hero a:hover {
    opacity: 0.8;
    text-decoration: underline;
}

/* CONTENT WRAPPER */
.blog-content-wrapper {
    background: #ffffff;
    padding: 60px 0;
}

/* ARTICLE */
.article-main {
    background: #ffffff;
}

.article-header {
    margin-bottom: 60px;
    padding-bottom: 50px;
    border-bottom: none;
    position: relative;
}

.article-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #ffd100 0%, #f0c000 50%, transparent 100%);
    border-radius: 2px;
}

.header-top {
    margin-bottom: 35px;
}

.article-title {
    font-size: 3.5rem;
    font-weight: 900;
    color: #1f2937;
    line-height: 1.15;
    margin: 0;
    word-wrap: break-word;
    word-break: break-word;
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: -0.5px;
}

.article-meta {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    font-size: 0.95rem;
    margin-top: 30px;
    padding-top: 30px;
}

.meta-item {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    background: linear-gradient(135deg, #fff8e1 0%, rgba(255, 241, 224, 0.5) 100%);
    border-radius: 8px;
    color: #666;
    font-weight: 600;
    white-space: nowrap;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    cursor: default;
    box-shadow: 0 2px 8px rgba(255, 209, 0, 0.08);
}

.meta-item:hover {
    border-color: #ffd100;
    background: linear-gradient(135deg, #fff8e1 0%, rgba(255, 209, 0, 0.1) 100%);
    box-shadow: 0 4px 16px rgba(255, 209, 0, 0.15);
    transform: translateY(-2px);
}

.meta-item i {
    color: #ffd100;
    font-size: 1.2rem;
    width: 24px;
    text-align: center;
}

.meta-text {
    color: #374151;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.article-divider {
    height: 4px;
    background: linear-gradient(90deg, #ffd100 0%, #f0c000 50%, transparent 100%);
    margin: 0;
    border-radius: 2px;
    position: relative;
    top: 50px;
}

.article-divider::before {
    content: '';
    position: absolute;
    top: -8px;
    left: 0;
    width: 40px;
    height: 8px;
    background: #ffd100;
    border-radius: 4px;
    animation: slideIn 0.6s ease-out;
}

@keyframes slideIn {
    from {
        width: 0;
        opacity: 0;
    }
    to {
        width: 40px;
        opacity: 1;
    }
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .article-title {
        font-size: 2.8rem;
    }

    .article-meta {
        gap: 15px;
    }

    .meta-item {
        padding: 10px 14px;
        font-size: 0.9rem;
    }

    .meta-item i {
        font-size: 1.1rem;
    }
}

@media (max-width: 768px) {
    .article-header {
        margin-bottom: 40px;
        padding-bottom: 30px;
    }

    .header-top {
        margin-bottom: 25px;
    }

    .article-title {
        font-size: 2rem;
    }

    .article-meta {
        gap: 12px;
        margin-top: 20px;
        padding-top: 20px;
    }

    .meta-item {
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    .meta-item i {
        font-size: 1rem;
        width: 20px;
    }

    .article-divider {
        top: 35px;
    }
}

@media (max-width: 576px) {
    .article-header {
        margin-bottom: 30px;
        padding-bottom: 25px;
    }

    .header-top {
        margin-bottom: 20px;
    }

    .article-title {
        font-size: 1.5rem;
    }

    .article-meta {
        gap: 8px;
        margin-top: 15px;
        padding-top: 15px;
        flex-direction: column;
    }

    .meta-item {
        width: 100%;
        padding: 10px 12px;
        font-size: 0.8rem;
    }

    .meta-item i {
        font-size: 0.95rem;
    }

    .article-divider {
        top: 25px;
    }
}

.article-body {
    margin: 40px 0;
    padding: 30px 0;
    clear: both;
}

.content-text {
    font-size: 1.05rem;
    line-height: 1.85;
    color: #4b5563;
}

.content-text :deep(p) {
    margin-bottom: 20px;
}

.content-text :deep(h2) {
    font-size: 1.8rem;
    font-weight: 700;
    color: #ffd100;
    margin: 40px 0 20px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid #ffd100;
}

.content-text :deep(h3) {
    font-size: 1.4rem;
    font-weight: 600;
    color: #ffd100;
    margin: 30px 0 15px 0;
}

.content-text :deep(h4) {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1f2937;
    margin: 25px 0 12px 0;
}

.content-text :deep(ul),
.content-text :deep(ol) {
    margin: 20px 0 20px 30px;
}

.content-text :deep(li) {
    margin-bottom: 12px;
    color: #4b5563;
}

.content-text :deep(blockquote) {
    border-left: 5px solid #ffd100;
    padding: 20px 25px;
    margin: 25px 0;
    background: #fff8e1;
    border-radius: 6px;
    font-style: italic;
    color: #1f2937;
}

.content-text :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 30px 0;
    box-shadow: 0 4px 12px rgba(255, 209, 0, 0.15);
}

.content-text :deep(a) {
    color: #ffd100;
    text-decoration: none;
    font-weight: 600;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.content-text :deep(a:hover) {
    color: #f0c000;
    border-bottom-color: #ffd100;
}

.content-text :deep(table) {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.content-text :deep(th),
.content-text :deep(td) {
    border: 1px solid #e5e7eb;
    padding: 12px;
    text-align: left;
}

.content-text :deep(th) {
    background: #fff8e1;
    font-weight: 600;
}

/* ARTICLE FOOTER */
.article-footer {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 3px solid #fff8e1;
    clear: both;
}

.author-box {
    display: flex;
    gap: 25px;
    background: #fff8e1;
    padding: 30px;
    border-radius: 8px;
    border-left: 5px solid #ffd100;
}

.author-avatar {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
}

.author-avatar i {
    font-size: 3.5rem;
    color: #ffd100;
}

.author-info {
    flex: 1;
}

.author-info h5 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.author-info p {
    font-size: 0.9rem;
    color: #4b5563;
    line-height: 1.6;
    margin: 0;
}

/* SIDEBAR WIDGETS */
.sidebar-widget {
    background: #ffffff;
    border: 2px solid #fff8e1;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.sidebar-widget:hover {
    border-color: #ffd100;
    box-shadow: 0 6px 16px rgba(255, 209, 0, 0.1);
}

.widget-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 20px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid #ffd100;
    display: flex;
    align-items: center;
    gap: 10px;
}

.widget-title i {
    color: #ffd100;
    font-size: 1.2rem;
}

/* NAVIGATION LINKS */
.nav-links {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.nav-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 18px;
    background: #fff8e1;
    border: 2px solid #ffd100;
    border-radius: 6px;
    color: #f0c000;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.nav-link:hover {
    background: #ffd100;
    color: #333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 209, 0, 0.2);
}

/* CATEGORIES */
.categories-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.category-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: #fff8e1;
    border: 1px solid #ffd100;
    border-radius: 6px;
    color: #666;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.category-link:hover {
    background: #ffd100;
    color: #333;
    transform: translateX(3px);
}

.category-link .count {
    background: #ffd100;
    color: #333;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 700;
    min-width: 35px;
    text-align: center;
}

.category-link:hover .count {
    background: white;
    color: #ffd100;
}

/* RELATED POSTS */
.related-posts-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.related-post {
    padding: 14px 16px;
    background: #fff8e1;
    border: 1px solid #ffd100;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 4px solid #ffd100;
}

.related-post:hover {
    background: #ffd100;
    transform: translateX(3px);
}

.related-post h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 5px 0;
    line-height: 1.3;
}

.related-post:hover h6 {
    color: #333;
}

.related-date {
    font-size: 0.8rem;
    color: #f0c000;
    font-weight: 600;
}

.related-post:hover .related-date {
    color: #333;
}

/* RELATED ARTICLES SECTION */
.related-articles-section {
    background: #f9fafb;
    padding: 80px 0;
    border-top: 3px solid #fff8e1;
    margin-top: 60px;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1f2937;
    text-align: center;
    margin: 0 0 50px 0;
    position: relative;
    padding-bottom: 20px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 70px;
    height: 3px;
    background: #ffd100;
    border-radius: 2px;
}

.related-article-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.related-article-card:hover {
    box-shadow: 0 10px 25px rgba(255, 209, 0, 0.15);
    border-color: #ffd100;
    transform: translateY(-5px);
}

.card-image {
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: #f0f0f0;
    position: relative;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-article-card:hover .card-image img {
    transform: scale(1.08);
}

.placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ffd100 0%, #f0c000 100%);
    color: white;
    font-size: 3rem;
}

.card-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-content h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 10px 0;
    line-height: 1.4;
}

.card-content p {
    font-size: 0.9rem;
    color: #4b5563;
    margin: 0 0 12px 0;
    line-height: 1.5;
    flex: 1;
}

.read-more {
    color: #ffd100;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-block;
}

.related-article-card:hover .read-more {
    color: #f0c000;
    transform: translateX(3px);
}

/* NOT FOUND SECTION */
.not-found-section {
    background: #ffffff;
    padding: 100px 40px;
    text-align: center;
}

.not-found-section i {
    font-size: 4rem;
    color: #fff8e1;
    margin-bottom: 20px;
    display: block;
}

.not-found-section h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 15px 0;
}

.not-found-section p {
    color: #4b5563;
    margin: 0 0 30px 0;
    font-size: 1rem;
    line-height: 1.6;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 30px;
    background: #ffd100;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn:hover {
    background: #f0c000;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 209, 0, 0.3);
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .article-title {
        font-size: 2.2rem;
    }

    .article-meta {
        gap: 12px;
    }

    .meta-item {
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    .author-box {
        flex-direction: column;
        gap: 15px;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
    }

    .author-avatar i {
        font-size: 2.8rem;
    }

    .section-title {
        font-size: 1.8rem;
    }
}

@media (max-width: 768px) {
    .blog-hero-section {
        height: 300px;
        margin-bottom: 0;
    }

    .hero-content {
        padding: 20px 25px;
        bottom: 15px;
    }

    .breadcrumb-hero {
        font-size: 0.85rem;
    }

    .blog-content-wrapper {
        padding: 40px 0;
    }

    .article-header {
        margin-bottom: 35px;
        padding-bottom: 25px;
    }

    .article-title {
        font-size: 1.6rem;
        margin-bottom: 15px;
    }

    .article-meta {
        gap: 10px;
        flex-wrap: wrap;
    }

    .meta-item {
        padding: 7px 10px;
        font-size: 0.8rem;
    }

    .article-body {
        margin: 30px 0;
        padding: 20px 0;
    }

    .content-text {
        font-size: 1rem;
    }

    .content-text :deep(h2) {
        font-size: 1.4rem;
        margin: 30px 0 15px 0;
    }

    .content-text :deep(h3) {
        font-size: 1.2rem;
        margin: 20px 0 12px 0;
    }

    .sidebar-widget {
        padding: 20px;
        margin-bottom: 25px;
    }

    .widget-title {
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .article-footer {
        margin-top: 40px;
        padding-top: 30px;
    }

    .author-box {
        padding: 20px;
    }

    .author-info h5 {
        font-size: 1rem;
    }

    .author-info p {
        font-size: 0.85rem;
    }

    .related-articles-section {
        padding: 60px 0;
        margin-top: 40px;
    }

    .section-title {
        font-size: 1.5rem;
        margin-bottom: 35px;
    }

    .card-image {
        height: 180px;
    }

    .card-content {
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .blog-hero-section {
        height: 240px;
    }

    .hero-content {
        padding: 15px 15px;
        bottom: 10px;
    }

    .breadcrumb-hero {
        font-size: 0.75rem;
    }

    .article-title {
        font-size: 1.4rem;
        margin-bottom: 12px;
    }

    .article-meta {
        gap: 6px;
        flex-direction: column;
    }

    .meta-item {
        width: 100%;
        padding: 6px 10px;
        font-size: 0.75rem;
    }

    .article-body {
        margin: 20px 0;
        padding: 15px 0;
    }

    .content-text {
        font-size: 0.95rem;
    }

    .content-text :deep(h2) {
        font-size: 1.2rem;
    }

    .content-text :deep(h3) {
        font-size: 1rem;
    }

    .content-text :deep(blockquote) {
        padding: 12px 15px;
        margin: 15px 0;
    }

    .sidebar-widget {
        padding: 15px;
        margin-bottom: 20px;
    }

    .widget-title {
        font-size: 0.95rem;
        margin-bottom: 12px;
    }

    .nav-link {
        padding: 11px 14px;
        font-size: 0.9rem;
    }

    .related-article-card {
        border-radius: 6px;
    }

    .card-image {
        height: 150px;
    }

    .card-content {
        padding: 12px;
    }

    .section-title {
        font-size: 1.3rem;
        margin-bottom: 25px;
    }

    .not-found-section {
        padding: 60px 20px;
    }

    .not-found-section h3 {
        font-size: 1.5rem;
    }
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
    }

    .section-title {
        font-size: 1.8rem;
    }
}

@media (max-width: 768px) {
    .blog-hero-section {
        height: 280px;
    }

    .hero-content {
        padding: 20px;
    }

    .article-title {
        font-size: 1.6rem;
    }

    .article-header {
        margin-bottom: 25px;
    }

    .content-text {
        font-size: 1rem;
    }

    .content-text :deep(h2) {
        font-size: 1.4rem;
    }

    .content-text :deep(h3) {
        font-size: 1.1rem;
    }

    .sidebar-widget {
        padding: 18px;
        margin-bottom: 20px;
    }

    .widget-title {
        font-size: 1rem;
        margin-bottom: 12px;
    }

    .author-box {
        padding: 18px;
    }

    .author-avatar i {
        font-size: 2.8rem;
    }

    .section-title {
        font-size: 1.5rem;
        margin-bottom: 30px;
    }

    .card-image {
        height: 160px;
    }

    .card-content {
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .blog-hero-section {
        height: 220px;
    }

    .hero-content {
        padding: 15px;
    }

    .breadcrumb-hero {
        font-size: 0.85rem;
    }

    .article-title {
        font-size: 1.4rem;
    }

    .article-meta {
        gap: 8px;
    }

    .meta-item {
        font-size: 0.8rem;
        padding: 6px 10px;
    }

    .content-text :deep(blockquote) {
        padding: 12px 15px;
    }

    .related-article-card {
        border-radius: 6px;
    }

    .card-image {
        height: 140px;
    }

    .section-title {
        font-size: 1.3rem;
    }

    .not-found-section {
        padding: 60px 20px;
    }

    .not-found-section h3 {
        font-size: 1.5rem;
    }
}
</style>
