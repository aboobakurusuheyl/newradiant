<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <!-- Player Photo -->
    <div class="relative h-48 bg-gray-200">
      <img
        v-if="player.photo"
        :src="`/storage/${player.photo}`"
        :alt="player.display_name"
        class="w-full h-full object-cover"
      />
      <div v-else class="w-full h-full flex items-center justify-center bg-gray-200">
        <UserIcon class="h-16 w-16 text-gray-400" />
      </div>
      
      <!-- Jersey Number -->
      <div class="absolute top-4 left-4 bg-white bg-opacity-90 rounded-full w-10 h-10 flex items-center justify-center">
        <span class="font-bold text-lg text-gray-900">{{ player.jersey_number }}</span>
      </div>
      
      <!-- Captain Badge -->
      <div v-if="player.is_captain" class="absolute top-4 right-4">
        <div class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-bold">
          C
        </div>
      </div>
      
      <!-- Vice Captain Badge -->
      <div v-else-if="player.is_vice_captain" class="absolute top-4 right-4">
        <div class="bg-gray-500 text-white px-2 py-1 rounded-full text-xs font-bold">
          VC
        </div>
      </div>
    </div>

    <!-- Player Info -->
    <div class="p-4">
      <div class="flex items-start justify-between mb-2">
        <div>
          <h3 class="text-lg font-bold text-gray-900">{{ player.display_name }}</h3>
          <p v-if="player.position_detail" class="text-sm text-gray-600">{{ player.position_detail }}</p>
        </div>
        <span :class="positionBadgeClass" class="px-2 py-1 rounded-full text-xs font-medium">
          {{ player.position }}
        </span>
      </div>

      <!-- Player Details -->
      <div class="space-y-1 text-sm text-gray-600">
        <div class="flex justify-between">
          <span>Age:</span>
          <span>{{ player.age }} years</span>
        </div>
        <div class="flex justify-between">
          <span>Nationality:</span>
          <span>{{ player.nationality }}</span>
        </div>
        <div v-if="player.height" class="flex justify-between">
          <span>Height:</span>
          <span>{{ player.height }}cm</span>
        </div>
        <div v-if="player.preferred_foot" class="flex justify-between">
          <span>Foot:</span>
          <span>{{ player.preferred_foot }}</span>
        </div>
      </div>

      <!-- Career Stats Preview -->
      <div v-if="player.career_stats && Object.keys(player.career_stats).length > 0" class="mt-3 pt-3 border-t border-gray-200">
        <div class="grid grid-cols-3 gap-2 text-center text-xs">
          <div v-if="player.career_stats.goals !== undefined">
            <div class="font-bold text-gray-900">{{ player.career_stats.goals }}</div>
            <div class="text-gray-600">Goals</div>
          </div>
          <div v-if="player.career_stats.assists !== undefined">
            <div class="font-bold text-gray-900">{{ player.career_stats.assists }}</div>
            <div class="text-gray-600">Assists</div>
          </div>
          <div v-if="player.career_stats.appearances !== undefined">
            <div class="font-bold text-gray-900">{{ player.career_stats.appearances }}</div>
            <div class="text-gray-600">Apps</div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="mt-4 flex gap-2">
        <button
          @click="$emit('view', player)"
          class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm font-medium transition-colors"
        >
          View Details
        </button>
        <button
          @click="$emit('edit', player)"
          class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-medium transition-colors"
        >
          Edit
        </button>
        <button
          @click="$emit('toggle-captain', player)"
          :class="[
            'px-3 py-2 rounded text-sm font-medium transition-colors',
            player.is_captain || player.is_vice_captain
              ? 'bg-yellow-600 hover:bg-yellow-700 text-white'
              : 'bg-gray-600 hover:bg-gray-700 text-white'
          ]"
        >
          {{ player.is_captain ? 'Captain' : player.is_vice_captain ? 'Vice' : 'Captain?' }}
        </button>
        <button
          @click="$emit('delete', player)"
          class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm font-medium transition-colors"
        >
          Delete
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { UserIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  player: {
    type: Object,
    required: true
  }
})

defineEmits(['view', 'edit', 'delete', 'toggle-captain'])

const positionBadgeClass = computed(() => {
  return props.player.position_badge_class || 'bg-gray-100 text-gray-800'
})
</script>
