<template>
  <div class="min-h-screen bg-white">
    <!-- Hero Carousel -->
    <HeroCarousel />

    <!-- Quick Stats -->
    <section class="py-16 bg-white border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12">
          <div class="text-center">
            <div class="text-3xl font-bold text-newradiant-blue mb-2">45+</div>
            <div class="text-sm text-gray-600">Years of Excellence</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-newradiant-blue mb-2">100+</div>
            <div class="text-sm text-gray-600">Trophies Won</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-newradiant-blue mb-2">500+</div>
            <div class="text-sm text-gray-600">Academy Players</div>
          </div>
          <div class="text-center">
            <div class="text-3xl font-bold text-newradiant-blue mb-2">8</div>
            <div class="text-sm text-gray-600">League Titles</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Latest News -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Latest News</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Stay updated with the latest news, announcements, and updates from New Radiant Sports Club
          </p>
        </div>
        
        <div v-if="loading" class="text-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-newradiant-blue"></div>
          <p class="mt-4 text-gray-600 text-lg">Loading news...</p>
        </div>
        
        <div v-else-if="news.length > 0" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <NewsCard 
            v-for="article in news" 
            :key="article.id"
            :news-item="article"
          />
        </div>
        
        <div v-else class="text-center py-12">
          <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
          </div>
          <p class="text-gray-600 text-lg">No news articles available at the moment.</p>
        </div>

        <div class="text-center mt-12">
          <RouterLink 
            to="/news" 
            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white rounded-lg font-semibold text-lg hover:from-newradiant-dark-blue hover:to-newradiant-blue transition-all duration-200 shadow-lg"
          >
            View All News
            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </RouterLink>
        </div>
      </div>
    </section>

    <!-- Fixtures & Results -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Fixtures & Results</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Follow our upcoming matches and celebrate our recent victories
          </p>
        </div>
        
        <div v-if="fixturesLoading" class="text-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-newradiant-blue"></div>
          <p class="mt-4 text-gray-600 text-lg">Loading fixtures...</p>
        </div>
        
        <div v-else-if="fixtures.length > 0" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <FixtureCard 
            v-for="fixture in fixtures" 
            :key="fixture.id"
            :fixture="fixture"
          />
        </div>
        
        <div v-else class="text-center py-12">
          <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <p class="text-gray-600 text-lg">No fixtures available at the moment.</p>
        </div>

        <div class="text-center mt-12">
          <RouterLink 
            to="/fixtures" 
            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white rounded-lg font-semibold text-lg hover:from-newradiant-dark-blue hover:to-newradiant-blue transition-all duration-200 shadow-lg"
          >
            View All Fixtures
            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </RouterLink>
        </div>
      </div>
    </section>

    <!-- Honors Section -->
    <HonorsSection />

    <!-- Academy Highlight -->
    <AcademyHighlight />

    <!-- Fan Portal & Store -->
    <FanPortalSection />

    <!-- Media Gallery -->
    <MediaGallery />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/services/api'
import HeroCarousel from '@/components/HeroCarousel.vue'
import NewsCard from '@/components/NewsCard.vue'
import FixtureCard from '@/components/FixtureCard.vue'
import HonorsSection from '@/components/HonorsSection.vue'
import AcademyHighlight from '@/components/AcademyHighlight.vue'
import FanPortalSection from '@/components/FanPortalSection.vue'
import MediaGallery from '@/components/MediaGallery.vue'

const news = ref([])
const fixtures = ref([])
const loading = ref(false)
const fixturesLoading = ref(false)

const fetchNews = async () => {
  try {
    loading.value = true
    const response = await api.get('/news')
    news.value = response.data.data.map(article => ({
      ...article,
      icon: '📰',
      category: 'News',
      excerpt: article.content.substring(0, 150) + '...',
      author: 'New Radiant SC',
      author_title: 'Official',
      read_time: Math.ceil(article.content.length / 500)
    }))
  } catch (error) {
    console.error('Error fetching news:', error)
  } finally {
    loading.value = false
  }
}

const fetchFixtures = async () => {
  try {
    fixturesLoading.value = true
    const response = await api.get('/fixtures')
    fixtures.value = response.data.data.map(fixture => ({
      ...fixture,
      competition: 'Dhivehi Premier League',
      status: fixture.status || 'upcoming'
    }))
  } catch (error) {
    console.error('Error fetching fixtures:', error)
  } finally {
    fixturesLoading.value = false
  }
}

onMounted(() => {
  fetchNews()
  fetchFixtures()
})
</script>