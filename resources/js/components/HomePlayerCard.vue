<template>
  <div 
    class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden cursor-pointer h-full flex flex-col"
    @click="$emit('click', player)"
  >
    <!-- Player Photo -->
    <div class="relative aspect-square bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
      <img
        v-if="player.photo"
        :src="`/storage/${player.photo}`"
        :alt="player.display_name"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
      />
      <div v-else class="w-full h-full flex items-center justify-center">
        <UserIcon class="h-20 w-20 text-gray-400" />
      </div>
      
      <!-- Jersey Number -->
      <div class="absolute top-4 left-4 bg-white bg-opacity-95 rounded-full w-12 h-12 flex items-center justify-center shadow-lg">
        <span class="font-bold text-xl text-gray-900">{{ player.jersey_number }}</span>
      </div>
      
      <!-- Captain Badge -->
      <div v-if="player.is_captain" class="absolute top-4 right-4">
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
          C
        </div>
      </div>
      
      <!-- Vice Captain Badge -->
      <div v-else-if="player.is_vice_captain" class="absolute top-4 right-4">
        <div class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
          VC
        </div>
      </div>
      
      <!-- Position Badge -->
      <div class="absolute bottom-4 left-4">
        <span :class="positionBadgeClass" class="px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
          {{ player.position }}
        </span>
      </div>
      
      <!-- Hover Overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
    </div>

    <!-- Player Info -->
    <div class="p-6 flex-1 flex flex-col">
      <div class="mb-4">
        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-newradiant-blue transition-colors">
          {{ player.display_name }}
        </h3>
        <p v-if="player.position_detail" class="text-gray-600 text-sm">
          {{ player.position_detail }}
        </p>
      </div>

      <!-- Player Details -->
      <div class="space-y-2 text-sm text-gray-600 mb-4 flex-1">
        <div class="flex justify-between">
          <span class="font-medium">Age:</span>
          <span>{{ player.age }} years</span>
        </div>
        <div class="flex justify-between">
          <span class="font-medium">Nationality:</span>
          <span>{{ player.nationality }}</span>
        </div>
        <div v-if="player.height" class="flex justify-between">
          <span class="font-medium">Height:</span>
          <span>{{ player.height }}cm</span>
        </div>
      </div>

      <!-- Career Stats Preview -->
      <div v-if="player.career_stats && Object.keys(player.career_stats).length > 0" class="pt-4 border-t border-gray-200">
        <div class="grid grid-cols-3 gap-3 text-center">
          <div v-if="player.career_stats.goals !== undefined" class="bg-gray-50 rounded-lg p-2">
            <div class="font-bold text-gray-900 text-lg">{{ player.career_stats.goals }}</div>
            <div class="text-gray-600 text-xs">Goals</div>
          </div>
          <div v-if="player.career_stats.assists !== undefined" class="bg-gray-50 rounded-lg p-2">
            <div class="font-bold text-gray-900 text-lg">{{ player.career_stats.assists }}</div>
            <div class="text-gray-600 text-xs">Assists</div>
          </div>
          <div v-if="player.career_stats.appearances !== undefined" class="bg-gray-50 rounded-lg p-2">
            <div class="font-bold text-gray-900 text-lg">{{ player.career_stats.appearances }}</div>
            <div class="text-gray-600 text-xs">Apps</div>
          </div>
        </div>
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

defineEmits(['click'])

const positionBadgeClass = computed(() => {
  return props.player.position_badge_class || 'bg-gray-100 text-gray-800'
})
</script>
