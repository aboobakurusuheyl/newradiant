<template>
  <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
    <!-- Match Header -->
    <div class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white p-4">
      <div class="text-center">
        <div class="text-sm font-semibold mb-1">{{ fixture.competition }}</div>
        <div class="text-xs opacity-90">{{ formatDate(fixture.date) }}</div>
      </div>
    </div>

    <!-- Match Content -->
    <div class="p-6">
      <!-- Teams -->
      <div class="flex items-center justify-center mb-6">
        <!-- Home Team -->
        <div class="flex flex-col items-center flex-1">
          <div class="w-16 h-16 bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue rounded-full flex items-center justify-center mb-2 shadow-lg">
            <span class="text-white font-bold text-xl">NR</span>
          </div>
          <div class="text-center">
            <div class="font-semibold text-gray-900 text-sm">New Radiant SC</div>
            <div class="text-xs text-gray-500">Home</div>
          </div>
        </div>

        <!-- VS Section -->
        <div class="flex flex-col items-center mx-6">
          <div v-if="fixture.status === 'completed'" class="text-2xl font-bold text-gray-900 mb-1">
            {{ fixture.home_score }} - {{ fixture.away_score }}
          </div>
          <div v-else class="text-lg font-bold text-newradiant-blue mb-1">
            VS
          </div>
          <div class="text-xs text-gray-500">
            <span v-if="fixture.status === 'completed'">{{ getMatchResult() }}</span>
            <span v-else>{{ formatTime(fixture.time) }}</span>
          </div>
        </div>

        <!-- Away Team -->
        <div class="flex flex-col items-center flex-1">
          <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-2 shadow-lg">
            <span class="text-gray-600 font-bold text-xl">{{ getOpponentInitials(fixture.opponent) }}</span>
          </div>
          <div class="text-center">
            <div class="font-semibold text-gray-900 text-sm">{{ fixture.opponent }}</div>
            <div class="text-xs text-gray-500">Away</div>
          </div>
        </div>
      </div>

      <!-- Match Details -->
      <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <div class="flex items-center justify-center space-x-6 text-sm text-gray-600">
          <div class="flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-medium">{{ fixture.venue }}</span>
          </div>
          <div class="flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ formatDate(fixture.date) }} at {{ formatTime(fixture.time) }}</span>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex space-x-2">
        <button 
          v-if="fixture.status === 'upcoming'"
          class="flex-1 bg-newradiant-blue text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-newradiant-dark-blue transition-colors"
        >
          Get Tickets
        </button>
        <button 
          v-if="fixture.status === 'completed'"
          class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-colors"
        >
          View Highlights
        </button>
        <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
        </button>
        <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  fixture: {
    type: Object,
    required: true
  }
})

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    weekday: 'short',
    month: 'short',
    day: 'numeric'
  })
}

const formatTime = (timeString) => {
  const time = new Date(`2000-01-01T${timeString}`)
  return time.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  })
}

const getOpponentInitials = (opponent) => {
  return opponent
    .split(' ')
    .map(word => word.charAt(0))
    .join('')
    .toUpperCase()
    .substring(0, 2)
}

const getMatchResult = () => {
  const homeScore = parseInt(props.fixture.home_score)
  const awayScore = parseInt(props.fixture.away_score)
  
  if (homeScore > awayScore) {
    return 'Won'
  } else if (homeScore < awayScore) {
    return 'Lost'
  } else {
    return 'Draw'
  }
}
</script>
