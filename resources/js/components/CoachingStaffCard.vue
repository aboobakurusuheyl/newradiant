<template>
  <div 
    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group cursor-pointer transform hover:-translate-y-1"
    @click="$emit('click', staff)"
  >
    <!-- Staff Photo -->
    <div class="relative aspect-square overflow-hidden">
      <img 
        v-if="staff.photo"
        :src="`/storage/${staff.photo}`"
        :alt="staff.name"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
        @error="handleImageError"
      />
      <img
        v-else
        src="/img/player.png"
        :alt="staff.name"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
        @error="handleImageError"
      />
      <!-- Fallback when both images fail -->
      <div class="w-full h-full flex items-center justify-center" style="display: none;">
        <UserIcon class="h-20 w-20 text-gray-400" />
      </div>
    </div>

    <!-- Staff Info -->
    <div class="p-4">
      <h3 class="font-semibold text-gray-900 mb-1 text-lg">{{ staff.name }}</h3>
      <p class="text-newradiant-blue font-medium mb-2">{{ staff.role_title || 'Coach' }}</p>
      <p v-if="staff.experience" class="text-sm text-gray-600 mb-2">{{ staff.experience }} years experience</p>
      <p v-if="staff.specialization" class="text-sm text-gray-500">{{ staff.specialization }}</p>
    </div>
  </div>
</template>

<script setup>
import { UserIcon } from '@heroicons/vue/24/outline'

defineProps({
  staff: {
    type: Object,
    required: true
  }
})

defineEmits(['click'])

const handleImageError = (event) => {
  if (event.target.src.includes('/storage/')) {
    event.target.src = '/img/player.png'
  } else if (event.target.src.includes('/img/player.png')) {
    event.target.style.display = 'none'
    event.target.nextElementSibling.style.display = 'flex'
  }
}
</script>
