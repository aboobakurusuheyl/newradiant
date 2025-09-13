<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Loading State -->
    <div v-if="isLoading" class="py-16 bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center py-8">
          <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-newradiant-blue"></div>
          <p class="mt-4 text-gray-600">Loading article...</p>
        </div>
      </div>
    </div>
    
    <!-- Article Content -->
    <article v-else-if="article" class="bg-white">
      <!-- Featured Image Section -->
      <div v-if="article.featured_image" class="relative h-96 md:h-[500px] overflow-hidden">
        <img
          :src="getImageUrl(article.featured_image)"
          :alt="article.title"
          class="w-full h-full object-cover"
          @error="handleImageError"
        />
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        
        <!-- Category Badge on Image -->
        <div class="absolute top-6 left-6">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-newradiant-blue text-white">
            {{ article.category || article.type }}
          </span>
        </div>
      </div>
      
      <!-- Fallback Header for Articles without Images -->
      <div v-else class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <div class="mb-4">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-white bg-opacity-20 text-white">
                {{ article.category || article.type }}
              </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ article.title }}</h1>
            <p class="text-xl text-blue-100">
              {{ new Date(article.published_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
              }) }}
            </p>
          </div>
        </div>
      </div>
      
      <!-- Article Content -->
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Article Meta (when image is present) -->
        <div v-if="article.featured_image" class="mb-8">
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ article.title }}</h1>
          <div class="flex items-center text-gray-600 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="mr-4">{{ new Date(article.published_at).toLocaleDateString('en-US', {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            }) }}</span>
            <span class="mr-4">•</span>
            <span>{{ Math.ceil(article.content.length / 500) }} min read</span>
          </div>
        </div>
        
        <!-- Article Body -->
        <div class="prose prose-lg max-w-none">
          <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ article.content }}</div>
        </div>
        
        <!-- Author Info -->
        <div class="mt-12 pt-8 border-t border-gray-200">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue rounded-full flex items-center justify-center mr-4">
              <span class="text-white font-semibold text-lg">
                {{ (article.author?.name || 'New Radiant SC').charAt(0) }}
              </span>
            </div>
            <div>
              <p class="font-semibold text-gray-900">{{ article.author?.name || 'New Radiant SC' }}</p>
              <p class="text-sm text-gray-600">Official</p>
            </div>
          </div>
        </div>
        
        <!-- Back to News Button -->
        <div class="mt-8">
          <RouterLink 
            to="/news"
            class="inline-flex items-center text-newradiant-blue hover:text-newradiant-dark-blue font-semibold transition-colors"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to News
          </RouterLink>
        </div>
      </div>
    </article>
    
    <!-- Article Not Found -->
    <div v-else class="py-16 bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center py-8">
          <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Article Not Found</h2>
          <p class="text-gray-600 mb-6">The article you're looking for doesn't exist or has been removed.</p>
          <RouterLink 
            to="/news"
            class="inline-flex items-center px-4 py-2 bg-newradiant-blue text-white rounded-lg hover:bg-newradiant-dark-blue transition-colors"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to News
          </RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import api from '@/services/api'

const route = useRoute()
const article = ref(null)
const isLoading = ref(true)
const imageError = ref(false)

const getImageUrl = (imagePath) => {
  // If it's already a full URL, return as is
  if (imagePath.startsWith('http')) {
    return imagePath
  }
  
  // If it starts with 'img/', it's a local image
  if (imagePath.startsWith('img/')) {
    return `/${imagePath}`
  }
  
  // If it's a storage path, add /storage/ prefix
  if (imagePath.startsWith('storage/')) {
    return `/${imagePath}`
  }
  
  // Default fallback
  return `/${imagePath}`
}

const handleImageError = () => {
  imageError.value = true
}

onMounted(async () => {
  try {
    const response = await api.get(`/news/${route.params.id}`)
    article.value = response.data
  } catch (error) {
    console.error('Failed to load article:', error)
  } finally {
    isLoading.value = false
  }
})
</script>
