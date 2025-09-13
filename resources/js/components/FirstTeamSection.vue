<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">First Team</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Meet our talented squad of players who represent New Radiant SC on the field
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
          <p class="text-gray-600">Loading team...</p>
        </div>
      </div>

      <!-- Team Content -->
      <div v-else>
        <!-- Team Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
          <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-2">{{ teamStats.total_players || 0 }}</div>
            <div class="text-gray-600">Total Players</div>
          </div>
          <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="text-3xl font-bold text-green-600 mb-2">{{ teamStats.goalkeepers || 0 }}</div>
            <div class="text-gray-600">Goalkeepers</div>
          </div>
          <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-2">{{ teamStats.defenders || 0 }}</div>
            <div class="text-gray-600">Defenders</div>
          </div>
          <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="text-3xl font-bold text-yellow-600 mb-2">{{ teamStats.midfielders || 0 }}</div>
            <div class="text-gray-600">Midfielders</div>
          </div>
        </div>

        <!-- Players by Position -->
        <div class="space-y-12">
          <!-- Goalkeepers -->
          <div v-if="playersByPosition.Goalkeeper?.length > 0">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
              <div class="w-4 h-4 bg-green-500 rounded-full"></div>
              Goalkeepers
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <HomePlayerCard
                v-for="player in playersByPosition.Goalkeeper"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>

          <!-- Defenders -->
          <div v-if="playersByPosition.Defender?.length > 0">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
              <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
              Defenders
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              <HomePlayerCard
                v-for="player in playersByPosition.Defender"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>

          <!-- Midfielders -->
          <div v-if="playersByPosition.Midfielder?.length > 0">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
              <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
              Midfielders
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              <HomePlayerCard
                v-for="player in playersByPosition.Midfielder"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>

          <!-- Forwards -->
          <div v-if="playersByPosition.Forward?.length > 0">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
              <div class="w-4 h-4 bg-red-500 rounded-full"></div>
              Forwards
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              <HomePlayerCard
                v-for="player in playersByPosition.Forward"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>
        </div>

        <!-- View All Players Button -->
        <div class="text-center mt-12">
          <RouterLink
            to="/first-team"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors"
          >
            View Complete Squad
            <ArrowRightIcon class="ml-2 h-5 w-5" />
          </RouterLink>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { ArrowRightIcon } from '@heroicons/vue/24/outline'
import api from '@/services/api'
import HomePlayerCard from '@/components/HomePlayerCard.vue'

const router = useRouter()

// State
const players = ref([])
const teamStats = ref({})
const loading = ref(true)

// Computed
const playersByPosition = computed(() => {
  const grouped = {
    Goalkeeper: [],
    Defender: [],
    Midfielder: [],
    Forward: []
  }

  players.value.forEach(player => {
    if (grouped[player.position]) {
      grouped[player.position].push(player)
    }
  })

  // Sort each position by jersey number
  Object.keys(grouped).forEach(position => {
    grouped[position].sort((a, b) => a.jersey_number - b.jersey_number)
  })

  return grouped
})

// Methods
const fetchPlayers = async () => {
  try {
    loading.value = true
    const response = await api.get('/players')
    
    if (response.data.data) {
      players.value = response.data.data
    } else if (Array.isArray(response.data)) {
      players.value = response.data
    } else {
      players.value = []
    }
  } catch (error) {
    console.error('Error fetching players:', error)
  } finally {
    loading.value = false
  }
}

const fetchTeamStats = async () => {
  try {
    const response = await api.get('/players/team/stats')
    teamStats.value = response.data
  } catch (error) {
    console.error('Error fetching team stats:', error)
  }
}

const viewPlayer = (player) => {
  router.push(`/player/${player.id}`)
}

// Lifecycle
onMounted(() => {
  fetchPlayers()
  fetchTeamStats()
})
</script>
