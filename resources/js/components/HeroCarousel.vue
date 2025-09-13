<template>
  <div class="relative h-[80vh] min-h-[600px] overflow-hidden">
    <!-- Carousel Container -->
    <div class="relative h-full">
      <!-- Slide 1: Upcoming Match -->
      <div 
        v-show="currentSlide === 0"
        class="absolute inset-0 bg-gradient-to-r from-newradiant-blue via-newradiant-light-blue to-newradiant-blue"
      >
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="relative h-full flex items-center">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
              <div class="text-white">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white bg-opacity-20 backdrop-blur-sm mb-6">
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-sm font-semibold">Next Match</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight">
                  New Radiant SC
                  <span class="block text-3xl lg:text-5xl font-light">vs {{ upcomingMatch.opponent }}</span>
                </h1>
                <div class="flex flex-wrap items-center gap-6 mb-8">
                  <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-lg">{{ upcomingMatch.venue }}</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-lg">{{ upcomingMatch.time }}</span>
                  </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                  <RouterLink 
                    to="/fixtures" 
                    class="inline-flex items-center px-8 py-4 bg-white text-newradiant-blue rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg"
                  >
                    View Fixtures
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </RouterLink>
                  <RouterLink 
                    to="/academy" 
                    class="inline-flex items-center px-8 py-4 border-2 border-white text-white rounded-lg font-semibold text-lg hover:bg-white hover:text-newradiant-blue transition-colors"
                  >
                    Academy Portal
                  </RouterLink>
                </div>
              </div>
              <div class="hidden lg:block">
                <div class="relative">
                  <div class="w-96 h-96 mx-auto bg-white bg-opacity-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <div class="text-center">
                      <div class="text-6xl font-bold mb-4">NR</div>
                      <div class="text-xl font-semibold">New Radiant SC</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2: Academy News -->
      <div 
        v-show="currentSlide === 1"
        class="absolute inset-0 bg-gradient-to-r from-newradiant-success via-green-500 to-newradiant-success"
      >
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="relative h-full flex items-center">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
              <div class="text-white">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white bg-opacity-20 backdrop-blur-sm mb-6">
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="text-sm font-semibold">Academy News</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight">
                  Academy Registration
                  <span class="block text-3xl lg:text-5xl font-light">Now Open</span>
                </h1>
                <p class="text-xl mb-8 text-green-100 max-w-2xl">
                  Join our comprehensive football academy program for players aged 8-18. 
                  Professional coaching, modern facilities, and a pathway to excellence.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                  <RouterLink 
                    to="/academy/registration" 
                    class="inline-flex items-center px-8 py-4 bg-white text-green-600 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg"
                  >
                    Register Now
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </RouterLink>
                  <RouterLink 
                    to="/academy" 
                    class="inline-flex items-center px-8 py-4 border-2 border-white text-white rounded-lg font-semibold text-lg hover:bg-white hover:text-green-600 transition-colors"
                  >
                    Learn More
                  </RouterLink>
                </div>
              </div>
              <div class="hidden lg:block">
                <div class="relative">
                  <div class="w-96 h-96 mx-auto bg-white bg-opacity-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <div class="text-center">
                      <div class="text-6xl font-bold mb-4">⚽</div>
                      <div class="text-xl font-semibold">Youth Academy</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 3: Club Achievement -->
      <div 
        v-show="currentSlide === 2"
        class="absolute inset-0 bg-gradient-to-r from-newradiant-accent via-yellow-500 to-newradiant-accent"
      >
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="relative h-full flex items-center">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
              <div class="text-white">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white bg-opacity-20 backdrop-blur-sm mb-6">
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm font-semibold">Club Achievement</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight">
                  Return to
                  <span class="block text-3xl lg:text-5xl font-light">First Division</span>
                </h1>
                <p class="text-xl mb-8 text-yellow-100 max-w-2xl">
                  After years of hard work and determination, New Radiant SC has secured 
                  promotion back to the top tier of Maldivian football.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                  <RouterLink 
                    to="/news" 
                    class="inline-flex items-center px-8 py-4 bg-white text-yellow-600 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg"
                  >
                    Read More
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </RouterLink>
                  <RouterLink 
                    to="/about" 
                    class="inline-flex items-center px-8 py-4 border-2 border-white text-white rounded-lg font-semibold text-lg hover:bg-white hover:text-yellow-600 transition-colors"
                  >
                    Club History
                  </RouterLink>
                </div>
              </div>
              <div class="hidden lg:block">
                <div class="relative">
                  <div class="w-96 h-96 mx-auto bg-white bg-opacity-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <div class="text-center">
                      <div class="text-6xl font-bold mb-4">🏆</div>
                      <div class="text-xl font-semibold">Champions</div>
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
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
      <button 
        v-for="(slide, index) in slides" 
        :key="index"
        @click="goToSlide(index)"
        class="w-3 h-3 rounded-full transition-all duration-300"
        :class="currentSlide === index ? 'bg-white' : 'bg-white bg-opacity-50'"
      ></button>
    </div>

    <!-- Navigation Arrows -->
    <button 
      @click="previousSlide"
      class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all duration-300 backdrop-blur-sm"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button 
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
import { ref, onMounted, onUnmounted } from 'vue'
import { RouterLink } from 'vue-router'

const currentSlide = ref(0)
const slides = ref(3)
let autoplayInterval = null

const upcomingMatch = ref({
  opponent: 'Maziya S&RC',
  venue: 'Rasmee Dhandu Stadium',
  time: '16:00',
  date: 'September 20, 2025'
})

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.value
}

const previousSlide = () => {
  currentSlide.value = currentSlide.value === 0 ? slides.value - 1 : currentSlide.value - 1
}

const goToSlide = (index) => {
  currentSlide.value = index
}

const startAutoplay = () => {
  autoplayInterval = setInterval(nextSlide, 5000)
}

const stopAutoplay = () => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval)
    autoplayInterval = null
  }
}

onMounted(() => {
  startAutoplay()
})

onUnmounted(() => {
  stopAutoplay()
})
</script>
