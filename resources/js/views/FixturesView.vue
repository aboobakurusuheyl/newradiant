<template>
  <div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Fixtures & Results</h1>
        <p class="text-xl text-gray-600">Upcoming matches and recent results</p>
      </div>
      
      <div v-if="isLoading" class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-newradiant-blue"></div>
      </div>
      
      <div v-else class="space-y-6">
        <div 
          v-for="fixture in fixtures" 
          :key="fixture.id"
          class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow"
        >
          <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
              <div class="flex items-center space-x-4 mb-2">
                <div class="text-sm text-gray-500">
                  {{ new Date(fixture.match_date).toLocaleDateString() }} at {{ fixture.match_time }}
                </div>
                <span 
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="{
                    'bg-green-100 text-green-800': fixture.status === 'completed',
                    'bg-blue-100 text-blue-800': fixture.status === 'scheduled',
                    'bg-yellow-100 text-yellow-800': fixture.status === 'in_progress'
                  }"
                >
                  {{ fixture.status }}
                </span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">
                New Radiant SC vs {{ fixture.opponent }}
              </h3>
              <p class="text-gray-600">{{ fixture.venue }} • {{ fixture.competition }}</p>
            </div>
            <div v-if="fixture.status === 'completed'" class="mt-4 md:mt-0 text-center">
              <div class="text-3xl font-bold text-gray-900">
                {{ fixture.our_score }} - {{ fixture.opponent_score }}
              </div>
              <div class="text-sm text-gray-500">
                {{ fixture.our_score > fixture.opponent_score ? 'W' : 
                   fixture.our_score < fixture.opponent_score ? 'L' : 'D' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const fixtures = ref([])
const isLoading = ref(true)

onMounted(async () => {
  try {
    const response = await api.get('/fixtures')
    fixtures.value = response.data.data
  } catch (error) {
    console.error('Failed to load fixtures:', error)
  } finally {
    isLoading.value = false
  }
})
</script>
