<template>
  <div class="relative h-[80vh] min-h-[600px] overflow-hidden">
    <!-- Loading State -->
    <div v-if="loading" class="absolute inset-0 bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue flex items-center justify-center">
      <div class="text-center text-white">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-white mb-4"></div>
        <p class="text-xl">Loading hero sections...</p>
      </div>
    </div>

    <!-- Carousel Container -->
    <div v-else class="relative h-full">
      <!-- Dynamic Hero Sections -->
      <div 
        v-for="(section, index) in heroSections" 
        :key="section.id"
        v-show="currentSlide === index"
        class="absolute inset-0 transition-all duration-500"
        :style="getSlideStyle(section)"
      >
        <!-- Background Image -->
        <div 
          v-if="section.image"
          class="absolute inset-0 bg-cover bg-center bg-no-repeat"
          :style="{ backgroundImage: `url(${getImageUrl(section.image)})` }"
        ></div>
        
        <!-- Fallback Background Image from img folder -->
        <div 
          v-else
          class="absolute inset-0 bg-cover bg-center bg-no-repeat"
          :style="{ backgroundImage: `url(${getFallbackImage(section)})` }"
        ></div>
        
        <!-- Gradient Overlay with black blur from right -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-black/80"></div>
        
        <!-- Content -->
        <div class="relative h-full flex items-center">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
              <div class="text-white">
                <!-- Subtitle Badge -->
                <div v-if="section.subtitle" class="inline-flex items-center px-4 py-2 rounded-full bg-white bg-opacity-20 backdrop-blur-sm mb-6">
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.95-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm font-semibold">{{ section.subtitle }}</span>
                </div>
                
                <!-- Title -->
                <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight line-clamp-3">
                  {{ section.title }}
                </h1>
                
                <!-- Description -->
                <p v-if="section.description" class="text-xl mb-8 text-white/90 max-w-2xl">
                  {{ section.description }}
                </p>
                
                <!-- Buttons -->
                <div v-if="section.button_text" class="flex flex-col sm:flex-row gap-4">
                  <RouterLink 
                    :to="section.button_link || '#'" 
                    class="inline-flex items-center px-8 py-4 bg-white text-newradiant-blue rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg"
                  >
                    {{ section.button_text }}
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </RouterLink>
                </div>
              </div>
              
              <!-- Right Side Content -->
              <div class="hidden lg:block">
                <div class="relative">
                  <div class="w-96 h-96 mx-auto bg-white bg-opacity-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <div class="text-center">
                      <div class="w-24 h-24 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <div class="text-xl font-semibold">New Radiant SC</div>
                      <div class="text-sm opacity-80">Pride of Maldivian Football</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Dots -->
    <div v-if="heroSections.length > 1" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
      <button 
        v-for="(section, index) in heroSections" 
        :key="section.id"
        @click="goToSlide(index)"
        class="w-3 h-3 rounded-full transition-all duration-300"
        :class="currentSlide === index ? 'bg-white' : 'bg-white bg-opacity-50'"
      ></button>
    </div>

    <!-- Navigation Arrows -->
    <button 
      v-if="heroSections.length > 1"
      @click="previousSlide"
      class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all duration-300 backdrop-blur-sm"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button 
      v-if="heroSections.length > 1"
      @click="nextSlide"
      class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all duration-300 backdrop-blur-sm"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/services/api'

// State
const heroSections = ref([])
const loading = ref(true)
const currentSlide = ref(0)
let autoplayInterval = null

// Computed
const slides = computed(() => heroSections.value.length)

// Methods
const fetchHeroSections = async () => {
  try {
    loading.value = true
    const response = await api.get('/hero-sections')
    heroSections.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching hero sections:', error)
    // Fallback to default content if API fails
    heroSections.value = [
      {
        id: 1,
        title: 'New Radiant SC - Pride of Maldivian Football',
        subtitle: 'Established 1979',
        description: 'Join us in celebrating over four decades of football excellence. From our historic victories to our commitment to youth development, New Radiant continues to be the pride of Maldivian football.',
        button_text: 'Join Our Academy',
        button_link: '/academy',
        type: 'hero',
        image: null
      },
      {
        id: 2,
        title: 'Championship Legacy - Building Future Stars',
        subtitle: 'Academy Excellence',
        description: 'Our youth academy continues to produce talented players who represent the future of Maldivian football. Join our comprehensive training program.',
        button_text: 'View First Team',
        button_link: '/first-team',
        type: 'announcement',
        image: null
      },
      {
        id: 3,
        title: 'Community Spirit - United in Blue',
        subtitle: 'Fan Engagement',
        description: 'Be part of the New Radiant family. Support our team, join our community events, and celebrate the beautiful game with fellow fans.',
        button_text: 'Visit Store',
        button_link: '/store',
        type: 'promotion',
        image: null
      }
    ]
  } finally {
    loading.value = false
  }
}

const getImageUrl = (imagePath) => {
  if (!imagePath) return null
  if (imagePath.startsWith('http')) return imagePath
  return `/storage/${imagePath}`
}

const getFallbackImage = (section) => {
  // Use images from the img folder as fallbacks
  const fallbackImages = [
    '/img/team.jpg',
    '/img/champ.jpg',
    '/img/im2.jpg',
    '/img/image.jpg',
    '/img/img.jpg'
  ]
  
  // Use section index to pick a consistent fallback image
  const index = (section.id || 0) % fallbackImages.length
  return fallbackImages[index]
}

const getSlideStyle = (section) => {
  // Default gradient based on type
  const gradients = {
    hero: 'background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #1e40af 100%)',
    announcement: 'background: linear-gradient(135deg, #059669 0%, #10b981 50%, #059669 100%)',
    promotion: 'background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #d97706 100%)'
  }
  
  return gradients[section.type] || gradients.hero
}

const nextSlide = () => {
  if (heroSections.value.length === 0) return
  currentSlide.value = (currentSlide.value + 1) % heroSections.value.length
}

const previousSlide = () => {
  if (heroSections.value.length === 0) return
  currentSlide.value = currentSlide.value === 0 ? heroSections.value.length - 1 : currentSlide.value - 1
}

const goToSlide = (index) => {
  currentSlide.value = index
}

const startAutoplay = () => {
  if (heroSections.value.length <= 1) return
  autoplayInterval = setInterval(nextSlide, 5000)
}

const stopAutoplay = () => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval)
    autoplayInterval = null
  }
}

// Lifecycle
onMounted(() => {
  fetchHeroSections().then(() => {
    startAutoplay()
  })
})

onUnmounted(() => {
  stopAutoplay()
})
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>