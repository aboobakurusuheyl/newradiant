<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-5xl lg:text-6xl font-bold mb-6">News & Announcements</h1>
          <p class="text-xl lg:text-2xl text-blue-100 max-w-3xl mx-auto">
            Stay updated with the latest news, announcements, and updates from New Radiant Sports Club
          </p>
        </div>
      </div>
    </section>

    <!-- News Content -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-newradiant-blue"></div>
          <p class="mt-4 text-gray-600 text-lg">Loading news...</p>
        </div>

        <!-- News Grid -->
        <div v-else-if="news.length > 0" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <NewsCard 
            v-for="article in news" 
            :key="article.id"
            :news-item="article"
          />
        </div>
        
        <!-- No News State -->
        <div v-else class="text-center py-12">
          <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
          </div>
          <p class="text-gray-600 text-lg">No news articles available at the moment.</p>
        </div>

        <!-- Pagination -->
        <div v-if="pagination && pagination.last_page > 1" class="mt-16 flex justify-center">
          <nav class="flex items-center space-x-2">
            <!-- Previous Button -->
            <button
              @click="goToPage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Previous
            </button>

            <!-- Page Numbers -->
            <template v-for="page in visiblePages" :key="page">
              <button
                v-if="page !== '...'"
                @click="goToPage(page)"
                :class="[
                  'px-3 py-2 text-sm font-medium rounded-md',
                  page === pagination.current_page
                    ? 'bg-newradiant-blue text-white'
                    : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50'
                ]"
              >
                {{ page }}
              </button>
              <span v-else class="px-3 py-2 text-sm text-gray-500">...</span>
            </template>

            <!-- Next Button -->
            <button
              @click="goToPage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Next
            </button>
          </nav>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/services/api'
import NewsCard from '@/components/NewsCard.vue'

const news = ref([])
const loading = ref(false)
const pagination = ref(null)
const currentPage = ref(1)

const fetchNews = async (page = 1) => {
  try {
    loading.value = true
    const response = await api.get(`/news?page=${page}`)
    
    if (response.data.data) {
      news.value = response.data.data.map(article => ({
        ...article,
        icon: '📰',
        category: article.category || 'general',
        excerpt: article.excerpt || article.content.substring(0, 150) + '...',
        author: article.author?.name || 'New Radiant SC',
        author_title: 'Official',
        read_time: Math.ceil(article.content.length / 500)
      }))
      
      pagination.value = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        per_page: response.data.per_page,
        total: response.data.total
      }
    } else if (Array.isArray(response.data)) {
      news.value = response.data.map(article => ({
        ...article,
        icon: '📰',
        category: article.category || 'general',
        excerpt: article.excerpt || article.content.substring(0, 150) + '...',
        author: article.author?.name || 'New Radiant SC',
        author_title: 'Official',
        read_time: Math.ceil(article.content.length / 500)
      }))
    }
  } catch (error) {
    console.error('Error fetching news:', error)
  } finally {
    loading.value = false
  }
}

const goToPage = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    currentPage.value = page
    fetchNews(page)
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const visiblePages = computed(() => {
  if (!pagination.value) return []
  
  const current = pagination.value.current_page
  const last = pagination.value.last_page
  const pages = []
  
  if (last <= 7) {
    for (let i = 1; i <= last; i++) {
      pages.push(i)
    }
  } else {
    if (current <= 4) {
      for (let i = 1; i <= 5; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(last)
    } else if (current >= last - 3) {
      pages.push(1)
      pages.push('...')
      for (let i = last - 4; i <= last; i++) {
        pages.push(i)
      }
    } else {
      pages.push(1)
      pages.push('...')
      for (let i = current - 1; i <= current + 1; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(last)
    }
  }
  
  return pages
})

onMounted(() => {
  fetchNews()
})
</script>
