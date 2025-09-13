<template>
  <section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Gallery</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Capturing the spirit and passion of New Radiant Sports Club
        </p>
      </div>

      <!-- Gallery Categories -->
      <div class="flex flex-wrap justify-center gap-6 mb-16">
        <button 
          v-for="category in categories" 
          :key="category.id"
          @click="activeCategory = category.id"
          class="px-6 py-3 rounded-full font-semibold transition-all duration-300"
          :class="activeCategory === category.id 
            ? 'bg-newradiant-blue text-white shadow-lg' 
            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
        >
          {{ category.name }}
        </button>
      </div>

      <!-- Gallery Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <div 
          v-for="(image, index) in filteredImages" 
          :key="image.id"
          @click="openLightbox(index)"
          class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl"
        >
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
          <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
            <span class="text-6xl">{{ image.icon }}</span>
          </div>
          <div class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
            <h3 class="font-semibold text-lg mb-1">{{ image.title }}</h3>
            <p class="text-sm text-gray-200">{{ image.description }}</p>
          </div>
        </div>
      </div>

      <!-- Load More Button -->
      <div class="text-center mt-12">
        <button 
          @click="loadMore"
          class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white rounded-lg font-semibold text-lg hover:from-newradiant-dark-blue hover:to-newradiant-blue transition-all duration-200 shadow-lg"
        >
          Load More
          <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <div 
      v-if="lightboxOpen" 
      @click="closeLightbox"
      class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4"
    >
      <div class="relative max-w-4xl max-h-full">
        <button 
          @click="closeLightbox"
          class="absolute top-4 right-4 text-white hover:text-gray-300 z-10"
        >
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        
        <div class="bg-white rounded-xl p-8 max-w-2xl mx-auto">
          <div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center mb-6">
            <span class="text-8xl">{{ currentImage?.icon }}</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ currentImage?.title }}</h3>
          <p class="text-gray-600 mb-4">{{ currentImage?.description }}</p>
          <div class="flex justify-between items-center">
            <button 
              @click="previousImage"
              class="flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Previous
            </button>
            <span class="text-sm text-gray-500">{{ lightboxIndex + 1 }} of {{ filteredImages.length }}</span>
            <button 
              @click="nextImage"
              class="flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
            >
              Next
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeCategory = ref(1)
const lightboxOpen = ref(false)
const lightboxIndex = ref(0)

const categories = ref([
  { id: 1, name: 'All' },
  { id: 2, name: 'Matches' },
  { id: 3, name: 'Training' },
  { id: 4, name: 'Academy' },
  { id: 5, name: 'Fans' }
])

const images = ref([
  {
    id: 1,
    title: 'Championship Celebration',
    description: 'Celebrating our return to First Division',
    category: 2,
    icon: '🏆'
  },
  {
    id: 2,
    title: 'Training Session',
    description: 'First team training at Rasmee Dhandu Stadium',
    category: 3,
    icon: '⚽'
  },
  {
    id: 3,
    title: 'Youth Academy',
    description: 'Young players developing their skills',
    category: 4,
    icon: '👦'
  },
  {
    id: 4,
    title: 'Fan Support',
    description: 'Passionate supporters at the stadium',
    category: 5,
    icon: '📣'
  },
  {
    id: 5,
    title: 'Match Action',
    description: 'Intense league match action',
    category: 2,
    icon: '⚽'
  },
  {
    id: 6,
    title: 'Coaching Staff',
    description: 'Professional coaching team in action',
    category: 3,
    icon: '👨‍🏫'
  },
  {
    id: 7,
    title: 'Academy Graduates',
    description: 'Successful academy graduates',
    category: 4,
    icon: '🎓'
  },
  {
    id: 8,
    title: 'Stadium Atmosphere',
    description: 'Electric atmosphere at home matches',
    category: 5,
    icon: '🏟️'
  },
  {
    id: 9,
    title: 'Victory Moment',
    description: 'Celebrating a crucial win',
    category: 2,
    icon: '🎉'
  },
  {
    id: 10,
    title: 'Fitness Training',
    description: 'Physical conditioning sessions',
    category: 3,
    icon: '💪'
  },
  {
    id: 11,
    title: 'Academy Training',
    description: 'Structured youth development program',
    category: 4,
    icon: '⚽'
  },
  {
    id: 12,
    title: 'Fan Engagement',
    description: 'Community events and fan activities',
    category: 5,
    icon: '🤝'
  }
])

const filteredImages = computed(() => {
  if (activeCategory.value === 1) {
    return images.value
  }
  return images.value.filter(image => image.category === activeCategory.value)
})

const currentImage = computed(() => {
  return filteredImages.value[lightboxIndex.value]
})

const openLightbox = (index) => {
  lightboxIndex.value = index
  lightboxOpen.value = true
}

const closeLightbox = () => {
  lightboxOpen.value = false
}

const nextImage = () => {
  lightboxIndex.value = (lightboxIndex.value + 1) % filteredImages.value.length
}

const previousImage = () => {
  lightboxIndex.value = lightboxIndex.value === 0 ? filteredImages.value.length - 1 : lightboxIndex.value - 1
}

const loadMore = () => {
  // In a real application, this would load more images from an API
  console.log('Loading more images...')
}
</script>
