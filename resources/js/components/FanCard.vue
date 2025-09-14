<template>
  <div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-900">Your Fan Card</h3>
      <div class="flex space-x-2">
        <button
          @click="downloadCard"
          class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
        >
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Download
        </button>
        <button
          @click="shareCard"
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
        >
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
          </svg>
          Share
        </button>
      </div>
    </div>

    <!-- Fan Card Preview -->
    <div ref="fanCardRef" class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 rounded-lg p-8 text-white relative overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="absolute top-4 right-4 w-32 h-32 border-2 border-white rounded-full"></div>
        <div class="absolute bottom-4 left-4 w-24 h-24 border-2 border-white rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 border-2 border-white rounded-full"></div>
      </div>

      <!-- Club Logo -->
      <div class="flex items-center mb-6">
        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4 p-2">
          <Logo class="w-12 h-12" />
        </div>
        <div>
          <h2 class="text-2xl font-bold">New Radiant SC</h2>
          <p class="text-blue-200 text-sm">Pride of Maldivian Football</p>
        </div>
      </div>

      <!-- Member Info -->
      <div class="relative z-10">
        <div class="mb-6">
          <h3 class="text-3xl font-bold mb-2">{{ user?.name || 'Member Name' }}</h3>
          <p class="text-blue-200 text-lg">Proud Member Since {{ memberSince }}</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 gap-6 mb-6">
          <div class="bg-white bg-opacity-20 rounded-lg p-4">
            <div class="text-2xl font-bold">{{ enrolledStudents.length }}</div>
            <div class="text-blue-200 text-sm">Enrolled Students</div>
          </div>
          <div class="bg-white bg-opacity-20 rounded-lg p-4">
            <div class="text-2xl font-bold">{{ activeStudents.length }}</div>
            <div class="text-blue-200 text-sm">Active Students</div>
          </div>
        </div>

        <!-- Member ID -->
        <div class="bg-white bg-opacity-20 rounded-lg p-4">
          <div class="text-sm text-blue-200 mb-1">Member ID</div>
          <div class="text-lg font-mono">{{ user?.id ? `NR-${user.id.toString().padStart(4, '0')}` : 'NR-0000' }}</div>
        </div>
      </div>

      <!-- Footer -->
      <div class="absolute bottom-4 right-4 text-blue-200 text-xs">
        newradiant.mv
      </div>
    </div>

    <!-- Share Modal -->
    <div v-if="showShareModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeShareModal">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" @click.stop>
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Share Your Fan Card</h3>
          
          <!-- Social Media Buttons -->
          <div class="space-y-3">
            <button
              @click="shareToFacebook"
              class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
              Share on Facebook
            </button>
            
            <button
              @click="shareToTwitter"
              class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-sky-500 hover:bg-sky-600"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
              </svg>
              Share on Twitter
            </button>
            
            <button
              @click="shareToWhatsApp"
              class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
              </svg>
              Share on WhatsApp
            </button>
            
            <button
              @click="copyLink"
              class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              Copy Link
            </button>
          </div>
          
          <div class="mt-4 flex justify-end">
            <button
              @click="closeShareModal"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import html2canvas from 'html2canvas'
import Logo from './logo.vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  },
  enrolledStudents: {
    type: Array,
    default: () => []
  }
})

const fanCardRef = ref(null)
const showShareModal = ref(false)

const memberSince = computed(() => {
  if (!props.user?.created_at) return '2024'
  return new Date(props.user.created_at).getFullYear().toString()
})

const activeStudents = computed(() => 
  props.enrolledStudents.filter(student => student.enrollment_status === 'approved' && student.is_active)
)

const downloadCard = async () => {
  try {
    const canvas = await html2canvas(fanCardRef.value, {
      backgroundColor: null,
      scale: 2,
      useCORS: true
    })
    
    const link = document.createElement('a')
    link.download = `newradiant-fan-card-${props.user?.name?.replace(/\s+/g, '-').toLowerCase() || 'member'}.png`
    link.href = canvas.toDataURL()
    link.click()
  } catch (error) {
    console.error('Error generating image:', error)
    alert('Error generating image. Please try again.')
  }
}

const shareCard = () => {
  showShareModal.value = true
}

const closeShareModal = () => {
  showShareModal.value = false
}

const shareToFacebook = () => {
  const url = encodeURIComponent(window.location.origin)
  const text = encodeURIComponent(`I'm a proud member of New Radiant SC! Check out my fan card.`)
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`, '_blank')
  closeShareModal()
}

const shareToTwitter = () => {
  const text = encodeURIComponent(`I'm a proud member of New Radiant SC! Check out my fan card. #NewRadiantSC #MaldivianFootball`)
  const url = encodeURIComponent(window.location.origin)
  window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank')
  closeShareModal()
}

const shareToWhatsApp = () => {
  const text = encodeURIComponent(`I'm a proud member of New Radiant SC! Check out my fan card: ${window.location.origin}`)
  window.open(`https://wa.me/?text=${text}`, '_blank')
  closeShareModal()
}

const copyLink = async () => {
  try {
    await navigator.clipboard.writeText(window.location.origin)
    alert('Link copied to clipboard!')
  } catch (error) {
    console.error('Error copying link:', error)
    alert('Error copying link. Please try again.')
  }
  closeShareModal()
}
</script>
