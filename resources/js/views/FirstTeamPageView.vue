<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-5xl lg:text-6xl font-bold mb-6">First Team</h1>
          <p class="text-xl lg:text-2xl text-blue-100 max-w-3xl mx-auto">
            Meet our talented squad of players who represent New Radiant SC on the field
          </p>
        </div>
      </div>
    </section>

    <!-- Team Stats -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="text-4xl font-bold text-newradiant-blue mb-2">{{ teamStats.total_players || 0 }}</div>
            <div class="text-gray-600">Total Players</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold text-green-600 mb-2">{{ teamStats.goalkeepers || 0 }}</div>
            <div class="text-gray-600">Goalkeepers</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold text-blue-600 mb-2">{{ teamStats.defenders || 0 }}</div>
            <div class="text-gray-600">Defenders</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold text-yellow-600 mb-2">{{ teamStats.midfielders || 0 }}</div>
            <div class="text-gray-600">Midfielders</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Players Section -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-newradiant-blue"></div>
          <p class="mt-4 text-gray-600 text-lg">Loading team...</p>
        </div>

        <!-- Players Content -->
        <div v-else>
          <!-- Goalkeepers -->
          <div v-if="playersByPosition.Goalkeeper?.length > 0" class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
              <div class="w-4 h-4 bg-green-500 rounded-full"></div>
              Goalkeepers
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <HomePlayerCard
                v-for="player in playersByPosition.Goalkeeper"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>

          <!-- Defenders -->
          <div v-if="playersByPosition.Defender?.length > 0" class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
              <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
              Defenders
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
              <HomePlayerCard
                v-for="player in playersByPosition.Defender"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>

          <!-- Midfielders -->
          <div v-if="playersByPosition.Midfielder?.length > 0" class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
              <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
              Midfielders
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
              <HomePlayerCard
                v-for="player in playersByPosition.Midfielder"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>

          <!-- Forwards -->
          <div v-if="playersByPosition.Forward?.length > 0" class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
              <div class="w-4 h-4 bg-red-500 rounded-full"></div>
              Forwards
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
              <HomePlayerCard
                v-for="player in playersByPosition.Forward"
                :key="player.id"
                :player="player"
                @click="viewPlayer(player)"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
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
