<template>
  <div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">News & Announcements</h1>
        <p class="text-xl text-gray-600">Stay updated with the latest from New Radiant SC</p>
      </div>
      
      <div v-if="isLoading" class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-newradiant-blue"></div>
      </div>
      
      <div v-else class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <article 
          v-for="article in news" 
          :key="article.id"
          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
        >
          <div class="p-6">
            <div class="flex items-center mb-2">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-newradiant-blue text-white">
                {{ article.type }}
              </span>
              <span class="ml-2 text-sm text-gray-500">
                {{ new Date(article.published_at).toLocaleDateString() }}
              </span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">
              {{ article.title }}
            </h3>
            <p class="text-gray-600 mb-4">
              {{ article.content.substring(0, 150) }}...
            </p>
            <RouterLink 
              :to="`/news/${article.id}`" 
              class="inline-flex items-center text-newradiant-blue hover:text-newradiant-dark-blue"
            >
              Read more
              <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </RouterLink>
          </div>
        </article>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/services/api'

const news = ref([])
const isLoading = ref(true)

onMounted(async () => {
  try {
    const response = await api.get('/news')
    news.value = response.data.data
  } catch (error) {
    console.error('Failed to load news:', error)
  } finally {
    isLoading.value = false
  }
})
</script>
