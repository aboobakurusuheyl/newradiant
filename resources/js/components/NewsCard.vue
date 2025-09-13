<template>
  <article class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
    <!-- Image -->
    <div class="aspect-video bg-gradient-to-br from-gray-200 to-gray-300 relative overflow-hidden">
      <div class="absolute inset-0 flex items-center justify-center">
        <span class="text-6xl">{{ newsItem.icon }}</span>
      </div>
      <div class="absolute top-4 left-4">
        <span class="px-3 py-1 bg-newradiant-blue text-white text-xs font-semibold rounded-full">
          {{ newsItem.category }}
        </span>
      </div>
      <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
    </div>

    <!-- Content -->
    <div class="p-8">
      <div class="flex items-center text-sm text-gray-500 mb-3">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>{{ formatDate(newsItem.published_at) }}</span>
        <span class="mx-2">•</span>
        <span>{{ newsItem.read_time }} min read</span>
      </div>

      <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-newradiant-blue transition-colors line-clamp-2">
        {{ newsItem.title }}
      </h3>

      <p class="text-gray-600 mb-4 line-clamp-3">
        {{ newsItem.excerpt }}
      </p>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div class="w-8 h-8 bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue rounded-full flex items-center justify-center mr-3">
            <span class="text-white font-semibold text-sm">{{ newsItem.author.charAt(0) }}</span>
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-900">{{ newsItem.author }}</p>
            <p class="text-xs text-gray-500">{{ newsItem.author_title }}</p>
          </div>
        </div>
        
        <RouterLink 
          :to="`/news/${newsItem.id}`"
          class="inline-flex items-center text-newradiant-blue hover:text-newradiant-dark-blue font-semibold text-sm group-hover:translate-x-1 transition-all duration-300"
        >
          Read More
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </RouterLink>
      </div>
    </div>
  </article>
</template>

<script setup>
import { RouterLink } from 'vue-router'

const props = defineProps({
  newsItem: {
    type: Object,
    required: true
  }
})

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
