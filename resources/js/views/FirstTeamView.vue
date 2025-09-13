<template>
  <div class="p-6">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">First Team Management</h1>
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

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-12">
      <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <p class="text-gray-600">Loading players...</p>
      </div>
    </div>

    <!-- Players Table -->
    <div v-else class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jersey #</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nationality</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="player in filteredPlayers" :key="player.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <img
                      v-if="player.photo"
                      :src="`/storage/${player.photo}`"
                      :alt="player.display_name"
                      class="h-10 w-10 rounded-full object-cover"
                    />
                    <div v-else class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                      <UserIcon class="h-6 w-6 text-gray-500" />
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
                      {{ player.display_name }}
                      <span v-if="player.is_captain" class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">C</span>
                      <span v-else-if="player.is_vice_captain" class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">VC</span>
                    </div>
                    <div class="text-sm text-gray-500">{{ player.position_detail || player.position }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="player.position_badge_class" class="px-2 py-1 rounded-full text-xs font-medium">
                  {{ player.position }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                {{ player.jersey_number }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ player.age }} years
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ player.nationality }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="player.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 py-1 rounded-full text-xs font-medium">
                  {{ player.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                  <button
                    @click="editPlayer(player)"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Edit
                  </button>
                  <button
                    @click="deletePlayer(player)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Delete
                  </button>
                  <button
                    @click="toggleCaptain(player)"
                    :class="[
                      'px-2 py-1 rounded text-xs',
                      player.is_captain || player.is_vice_captain
                        ? 'bg-yellow-100 text-yellow-800'
                        : 'bg-gray-100 text-gray-800'
                    ]"
                  >
                    {{ player.is_captain ? 'Captain' : player.is_vice_captain ? 'Vice' : 'Make Captain' }}
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
import api from '@/services/api'
import {
  PlusIcon,
  UserGroupIcon,
  CheckCircleIcon,
  ClockIcon,
  StarIcon,
  UserIcon
} from '@heroicons/vue/24/outline'
import PlayerModal from '@/components/PlayerModal.vue'

const router = useRouter()
// API is already imported as default

// State
const players = ref([])
const teamStats = ref({})
const searchQuery = ref('')
const positionFilter = ref('all')
const statusFilter = ref('all')
const isPlayerModalOpen = ref(false)
const selectedPlayer = ref(null)
const loading = ref(true)

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
    loading.value = true
    const response = await api.get('/players')
    
    // Handle both paginated and non-paginated responses
    if (response.data.data) {
      // Paginated response
      players.value = response.data.data
    } else if (Array.isArray(response.data)) {
      // Direct array response
      players.value = response.data
    } else {
      // Fallback
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

const openPlayerModal = (player = null) => {
  selectedPlayer.value = player
  isPlayerModalOpen.value = true
}

const closePlayerModal = () => {
  isPlayerModalOpen.value = false
  selectedPlayer.value = null
}

// Removed viewPlayer method as it's not needed for admin list view

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
