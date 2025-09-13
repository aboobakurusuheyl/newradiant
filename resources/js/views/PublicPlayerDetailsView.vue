<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Player Header -->
    <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="flex items-center justify-between">
            <button
              @click="$router.go(-1)"
              class="flex items-center text-gray-600 hover:text-gray-900"
            >
              <ArrowLeftIcon class="h-5 w-5 mr-2" />
              Back to First Team
            </button>
            <div class="flex items-center space-x-4">
              <RouterLink
                to="/academy"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"
              >
                <UserGroupIcon class="h-4 w-4" />
                Academy Portal
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Player Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row items-center gap-8">
          <!-- Player Photo -->
          <div class="flex-shrink-0">
            <div class="relative">
              <img
                v-if="player?.photo"
                :src="`/storage/${player.photo}`"
                :alt="player.display_name"
                class="w-48 h-48 rounded-full object-cover border-4 border-white shadow-lg"
              />
              <div v-else class="w-48 h-48 rounded-full bg-gray-300 border-4 border-white shadow-lg flex items-center justify-center">
                <UserIcon class="h-24 w-24 text-gray-500" />
              </div>
              
              <!-- Jersey Number -->
              <div class="absolute -bottom-4 -right-4 bg-white text-blue-600 rounded-full w-16 h-16 flex items-center justify-center shadow-lg">
                <span class="text-2xl font-bold">{{ player?.jersey_number }}</span>
              </div>
            </div>
          </div>

          <!-- Player Info -->
          <div class="flex-1 text-center lg:text-left">
            <div class="flex items-center justify-center lg:justify-start gap-4 mb-4">
              <h1 class="text-4xl lg:text-5xl font-bold">{{ player?.display_name }}</h1>
              <div v-if="player?.is_captain" class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                C
              </div>
              <div v-else-if="player?.is_vice_captain" class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                VC
              </div>
            </div>
            
            <div class="text-xl lg:text-2xl text-blue-100 mb-4">
              {{ player?.position_detail || player?.position }}
            </div>
            
            <div class="text-lg text-blue-100 mb-6">
              {{ player?.nationality }} • {{ player?.age }} years old
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 max-w-2xl">
              <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold">{{ player?.career_stats?.appearances || 0 }}</div>
                <div class="text-sm text-blue-100">Matches</div>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold">{{ player?.career_stats?.goals || 0 }}</div>
                <div class="text-sm text-blue-100">Goals</div>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold">{{ player?.career_stats?.assists || 0 }}</div>
                <div class="text-sm text-blue-100">Assists</div>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold">{{ player?.career_stats?.clean_sheets || 0 }}</div>
                <div class="text-sm text-blue-100">Clean Sheets</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Personal Info & Career -->
        <div class="lg:col-span-2 space-y-8">
          <!-- Personal Information -->
          <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="text-sm font-medium text-gray-500">Full Name</label>
                <p class="text-lg text-gray-900">{{ player?.full_name }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Date of Birth</label>
                <p class="text-lg text-gray-900">{{ formatDate(player?.date_of_birth) }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Place of Birth</label>
                <p class="text-lg text-gray-900">{{ player?.nationality }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Height</label>
                <p class="text-lg text-gray-900">{{ player?.height }} cm</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Weight</label>
                <p class="text-lg text-gray-900">{{ player?.weight }} kg</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Preferred Foot</label>
                <p class="text-lg text-gray-900">{{ player?.preferred_foot }}</p>
              </div>
            </div>
          </div>

          <!-- Biography -->
          <div v-if="player?.biography" class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Biography</h2>
            <p class="text-gray-700 leading-relaxed">{{ player.biography }}</p>
          </div>

          <!-- Career Timeline -->
          <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Career</h2>
            <div class="space-y-4">
              <div v-if="player?.contract_start" class="flex items-center justify-between py-3 border-b border-gray-200">
                <div>
                  <div class="font-semibold text-gray-900">New Radiant SC</div>
                  <div class="text-sm text-gray-500">{{ formatDate(player.contract_start) }} - {{ formatDate(player.contract_end) || 'Present' }}</div>
                </div>
                <div class="text-sm text-gray-500">{{ player?.position }}</div>
              </div>
            </div>
          </div>

          <!-- Honours & Achievements -->
          <div v-if="player?.achievements && player.achievements.length > 0" class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Honours & Achievements</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div
                v-for="(achievement, index) in player.achievements"
                :key="index"
                class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-200"
              >
                <TrophyIcon class="h-6 w-6 text-yellow-600 mr-3 flex-shrink-0" />
                <span class="text-gray-900 font-medium">{{ achievement }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column - Statistics & Additional Info -->
        <div class="space-y-8">
          <!-- Season Statistics -->
          <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Season Statistics</h3>
            <div class="space-y-3">
              <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Matches Played</span>
                <span class="font-semibold">{{ player?.career_stats?.appearances || 0 }}</span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Goals</span>
                <span class="font-semibold">{{ player?.career_stats?.goals || 0 }}</span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Assists</span>
                <span class="font-semibold">{{ player?.career_stats?.assists || 0 }}</span>
              </div>
              <div v-if="player?.career_stats?.clean_sheets !== undefined" class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Clean Sheets</span>
                <span class="font-semibold">{{ player.career_stats.clean_sheets }}</span>
              </div>
              <div v-if="player?.career_stats?.tackles !== undefined" class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Tackles</span>
                <span class="font-semibold">{{ player.career_stats.tackles }}</span>
              </div>
              <div v-if="player?.career_stats?.passes !== undefined" class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Passes</span>
                <span class="font-semibold">{{ player.career_stats.passes }}</span>
              </div>
              <div v-if="player?.career_stats?.shots !== undefined" class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Shots</span>
                <span class="font-semibold">{{ player.career_stats.shots }}</span>
              </div>
            </div>
          </div>

          <!-- Position Information -->
          <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Position Details</h3>
            <div class="space-y-3">
              <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Position</span>
                <span :class="positionBadgeClass" class="px-2 py-1 rounded-full text-sm font-medium">
                  {{ player?.position }}
                </span>
              </div>
              <div v-if="player?.position_detail" class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Role</span>
                <span class="font-semibold">{{ player.position_detail }}</span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-600">Jersey Number</span>
                <span class="font-semibold text-2xl">{{ player?.jersey_number }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '@/services/api'
import {
  ArrowLeftIcon,
  UserIcon,
  TrophyIcon,
  UserGroupIcon
} from '@heroicons/vue/24/outline'

const route = useRoute()
const router = useRouter()
// API is already imported as default

// State
const player = ref(null)
const loading = ref(true)

// Computed
const positionBadgeClass = computed(() => {
  if (!player.value) return 'bg-gray-100 text-gray-800'
  return player.value.position_badge_class || 'bg-gray-100 text-gray-800'
})

// Methods
const fetchPlayer = async () => {
  try {
    loading.value = true
    const response = await api.get(`/players/${route.params.id}`)
    player.value = response.data
  } catch (error) {
    console.error('Error fetching player:', error)
    router.push('/')
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return 'Not specified'
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

// Lifecycle
onMounted(() => {
  fetchPlayer()
})
</script>
