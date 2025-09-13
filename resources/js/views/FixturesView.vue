<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-5xl lg:text-6xl font-bold mb-6">Fixtures & Results</h1>
          <p class="text-xl lg:text-2xl text-blue-100 max-w-3xl mx-auto">
            Stay updated with our upcoming matches and recent results
          </p>
        </div>
      </div>
    </section>

    <!-- Fixtures Content -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-newradiant-blue"></div>
          <p class="mt-4 text-gray-600 text-lg">Loading fixtures...</p>
        </div>

        <!-- Fixtures List -->
        <div v-else-if="fixtures.length > 0" class="space-y-6">
          <div 
            v-for="fixture in fixtures" 
            :key="fixture.id"
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden"
          >
            <div class="p-8">
              <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <!-- Match Info -->
                <div class="flex-1 mb-6 lg:mb-0">
                  <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center text-gray-600">
                      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <span class="font-medium">{{ formatDate(fixture.match_date) }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span>{{ fixture.match_time }}</span>
                    </div>
                    <span 
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold"
                      :class="getStatusClass(fixture.status)"
                    >
                      {{ getStatusText(fixture.status) }}
                    </span>
                  </div>
                  
                  <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-newradiant-blue transition-colors">
                    New Radiant SC vs {{ fixture.opponent }}
                  </h3>
                  
                  <div class="flex items-center text-gray-600 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="mr-4">{{ fixture.venue }}</span>
                    <span class="text-newradiant-blue font-medium">{{ fixture.competition || 'Dhivehi Premier League' }}</span>
                  </div>
                </div>

                <!-- Score (for completed matches) -->
                <div v-if="fixture.status === 'completed'" class="lg:ml-8 text-center">
                  <div class="text-4xl font-bold text-gray-900 mb-2">
                    {{ fixture.our_score }} - {{ fixture.opponent_score }}
                  </div>
                  <div class="flex items-center justify-center">
                    <span 
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold"
                      :class="getResultClass(fixture.our_score, fixture.opponent_score)"
                    >
                      {{ getResultText(fixture.our_score, fixture.opponent_score) }}
                    </span>
                  </div>
                </div>

                <!-- Upcoming Match Info -->
                <div v-else class="lg:ml-8 text-center">
                  <div class="text-2xl font-bold text-gray-900 mb-2">
                    {{ getTimeUntilMatch(fixture.match_date, fixture.match_time) }}
                  </div>
                  <div class="text-sm text-gray-600">
                    {{ fixture.type === 'home' ? 'Home Match' : 'Away Match' }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- No Fixtures State -->
        <div v-else class="text-center py-12">
          <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <p class="text-gray-600 text-lg">No fixtures available at the moment.</p>
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
import api from '@/services/api'

const fixtures = ref([])
const loading = ref(false)
const pagination = ref(null)
const currentPage = ref(1)

const fetchFixtures = async (page = 1) => {
  try {
    loading.value = true
    const response = await api.get(`/fixtures?page=${page}`)
    
    if (response.data.data) {
      fixtures.value = response.data.data.map(fixture => ({
        ...fixture,
        competition: fixture.competition || 'Dhivehi Premier League',
        status: fixture.status || 'scheduled'
      }))
      
      pagination.value = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        per_page: response.data.per_page,
        total: response.data.total
      }
    } else if (Array.isArray(response.data)) {
      fixtures.value = response.data.map(fixture => ({
        ...fixture,
        competition: fixture.competition || 'Dhivehi Premier League',
        status: fixture.status || 'scheduled'
      }))
    }
  } catch (error) {
    console.error('Error fetching fixtures:', error)
  } finally {
    loading.value = false
  }
}

const goToPage = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    currentPage.value = page
    fetchFixtures(page)
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

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const getStatusClass = (status) => {
  const classes = {
    'completed': 'bg-green-100 text-green-800',
    'scheduled': 'bg-blue-100 text-blue-800',
    'in_progress': 'bg-yellow-100 text-yellow-800',
    'cancelled': 'bg-red-100 text-red-800',
    'postponed': 'bg-gray-100 text-gray-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
  const texts = {
    'completed': 'Completed',
    'scheduled': 'Scheduled',
    'in_progress': 'Live',
    'cancelled': 'Cancelled',
    'postponed': 'Postponed'
  }
  return texts[status] || 'Scheduled'
}

const getResultClass = (ourScore, opponentScore) => {
  if (ourScore > opponentScore) {
    return 'bg-green-100 text-green-800'
  } else if (ourScore < opponentScore) {
    return 'bg-red-100 text-red-800'
  } else {
    return 'bg-yellow-100 text-yellow-800'
  }
}

const getResultText = (ourScore, opponentScore) => {
  if (ourScore > opponentScore) {
    return 'Win'
  } else if (ourScore < opponentScore) {
    return 'Loss'
  } else {
    return 'Draw'
  }
}

const getTimeUntilMatch = (matchDate, matchTime) => {
  const now = new Date()
  const matchDateTime = new Date(`${matchDate}T${matchTime}`)
  const diffTime = matchDateTime - now
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  
  if (diffDays < 0) {
    return 'Past Match'
  } else if (diffDays === 0) {
    return 'Today'
  } else if (diffDays === 1) {
    return 'Tomorrow'
  } else if (diffDays <= 7) {
    return `In ${diffDays} days`
  } else {
    return `In ${Math.ceil(diffDays / 7)} weeks`
  }
}

onMounted(() => {
  fetchFixtures()
})
</script>
