<template>
  <div class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="isLoading" class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-newradiant-blue"></div>
      </div>
      
      <article v-else-if="article" class="prose max-w-none">
        <div class="mb-6">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-newradiant-blue text-white">
            {{ article.type }}
          </span>
          <span class="ml-2 text-sm text-gray-500">
            {{ new Date(article.published_at).toLocaleDateString() }}
          </span>
        </div>
        
        <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ article.title }}</h1>
        
        <div class="text-gray-600 whitespace-pre-line">{{ article.content }}</div>
      </article>
      
      <div v-else class="text-center py-8">
        <p class="text-gray-500">Article not found</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/services/api'

const route = useRoute()
const article = ref(null)
const isLoading = ref(true)

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
