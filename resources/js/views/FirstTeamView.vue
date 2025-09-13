<template>
  <div class="p-6">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">First Team</h1>
          <p class="text-gray-600 mt-2">Manage New Radiant SC first team players</p>
        </div>
        <button
          @click="openPlayerModal()"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"
        >
          <PlusIcon class="h-5 w-5" />
          Add Player
        </button>
      </div>
    </div>

    <!-- Team Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <UserGroupIcon class="h-6 w-6 text-blue-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Players</p>
            <p class="text-2xl font-bold text-gray-900">{{ teamStats.total_players || 0 }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <CheckCircleIcon class="h-6 w-6 text-green-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Active Players</p>
            <p class="text-2xl font-bold text-gray-900">{{ teamStats.active_players || 0 }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <ClockIcon class="h-6 w-6 text-yellow-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Average Age</p>
            <p class="text-2xl font-bold text-gray-900">{{ Math.round(teamStats.average_age || 0) }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-purple-100 rounded-lg">
            <StarIcon class="h-6 w-6 text-purple-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Captain</p>
            <p class="text-lg font-bold text-gray-900">{{ teamStats.captain?.display_name || 'Not Set' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search players..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
        </div>
        <div class="flex gap-4">
          <select
            v-model="positionFilter"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          >
            <option value="all">All Positions</option>
            <option value="Goalkeeper">Goalkeeper</option>
            <option value="Defender">Defender</option>
            <option value="Midfielder">Midfielder</option>
            <option value="Forward">Forward</option>
          </select>
          <select
            v-model="statusFilter"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          >
            <option value="all">All Status</option>
            <option value="true">Active</option>
            <option value="false">Inactive</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Players by Position -->
    <div class="space-y-8">
      <!-- Goalkeepers -->
      <div v-if="playersByPosition.Goalkeeper?.length > 0">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
          <div class="w-3 h-3 bg-green-500 rounded-full"></div>
          Goalkeepers
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <PlayerCard
            v-for="player in playersByPosition.Goalkeeper"
            :key="player.id"
            :player="player"
            @view="viewPlayer"
            @edit="editPlayer"
            @delete="deletePlayer"
            @toggle-captain="toggleCaptain"
          />
        </div>
      </div>

      <!-- Defenders -->
      <div v-if="playersByPosition.Defender?.length > 0">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
          <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
          Defenders
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <PlayerCard
            v-for="player in playersByPosition.Defender"
            :key="player.id"
            :player="player"
            @view="viewPlayer"
            @edit="editPlayer"
            @delete="deletePlayer"
            @toggle-captain="toggleCaptain"
          />
        </div>
      </div>

      <!-- Midfielders -->
      <div v-if="playersByPosition.Midfielder?.length > 0">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
          <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
          Midfielders
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <PlayerCard
            v-for="player in playersByPosition.Midfielder"
            :key="player.id"
            :player="player"
            @view="viewPlayer"
            @edit="editPlayer"
            @delete="deletePlayer"
            @toggle-captain="toggleCaptain"
          />
        </div>
      </div>

      <!-- Forwards -->
      <div v-if="playersByPosition.Forward?.length > 0">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
          <div class="w-3 h-3 bg-red-500 rounded-full"></div>
          Forwards
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <PlayerCard
            v-for="player in playersByPosition.Forward"
            :key="player.id"
            :player="player"
            @view="viewPlayer"
            @edit="editPlayer"
            @delete="deletePlayer"
            @toggle-captain="toggleCaptain"
          />
        </div>
      </div>
    </div>

    <!-- Player Modal -->
    <PlayerModal
      :is-open="isPlayerModalOpen"
      :player="selectedPlayer"
      @close="closePlayerModal"
      @save="savePlayer"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useApi } from '@/services/api'
import {
  PlusIcon,
  UserGroupIcon,
  CheckCircleIcon,
  ClockIcon,
  StarIcon
} from '@heroicons/vue/24/outline'
import PlayerCard from '@/components/PlayerCard.vue'
import PlayerModal from '@/components/PlayerModal.vue'

const router = useRouter()
const api = useApi()

// State
const players = ref([])
const teamStats = ref({})
const searchQuery = ref('')
const positionFilter = ref('all')
const statusFilter = ref('all')
const isPlayerModalOpen = ref(false)
const selectedPlayer = ref(null)

// Computed
const filteredPlayers = computed(() => {
  let filtered = players.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(player => 
      player.first_name.toLowerCase().includes(query) ||
      player.last_name.toLowerCase().includes(query) ||
      player.nickname?.toLowerCase().includes(query) ||
      player.jersey_number.toString().includes(query)
    )
  }

  if (positionFilter.value !== 'all') {
    filtered = filtered.filter(player => player.position === positionFilter.value)
  }

  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(player => 
      statusFilter.value === 'true' ? player.is_active : !player.is_active
    )
  }

  return filtered
})

const playersByPosition = computed(() => {
  const grouped = {
    Goalkeeper: [],
    Defender: [],
    Midfielder: [],
    Forward: []
  }

  filteredPlayers.value.forEach(player => {
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
    const response = await api.get('/players')
    players.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching players:', error)
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

const openPlayerModal = (player = null) => {
  selectedPlayer.value = player
  isPlayerModalOpen.value = true
}

const closePlayerModal = () => {
  isPlayerModalOpen.value = false
  selectedPlayer.value = null
}

const viewPlayer = (player) => {
  router.push(`/academy/first-team/player/${player.id}`)
}

const editPlayer = (player) => {
  openPlayerModal(player)
}

const savePlayer = async (playerData) => {
  try {
    if (selectedPlayer.value) {
      // Update existing player
      await api.put(`/players/${selectedPlayer.value.id}`, playerData)
    } else {
      // Create new player
      await api.post('/players', playerData)
    }
    
    await fetchPlayers()
    await fetchTeamStats()
    closePlayerModal()
  } catch (error) {
    console.error('Error saving player:', error)
  }
}

const deletePlayer = async (player) => {
  if (confirm(`Are you sure you want to delete ${player.display_name}?`)) {
    try {
      await api.delete(`/players/${player.id}`)
      await fetchPlayers()
      await fetchTeamStats()
    } catch (error) {
      console.error('Error deleting player:', error)
    }
  }
}

const toggleCaptain = async (player) => {
  try {
    await api.post(`/players/${player.id}/captain`, {
      is_captain: !player.is_captain,
      is_vice_captain: player.is_vice_captain
    })
    await fetchPlayers()
    await fetchTeamStats()
  } catch (error) {
    console.error('Error updating captain status:', error)
  }
}

// Lifecycle
onMounted(() => {
  fetchPlayers()
  fetchTeamStats()
})

// Watch for filter changes
watch([searchQuery, positionFilter, statusFilter], () => {
  // Filters are applied in computed properties
})
</script>
