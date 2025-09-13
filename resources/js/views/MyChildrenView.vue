<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">My Children</h1>
          <p class="text-gray-600">Manage your children's academy enrollment and information</p>
        </div>
        <RouterLink 
          to="/academy/enroll" 
          class="bg-newradiant-blue text-white px-6 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors flex items-center"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Enroll New Child
        </RouterLink>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <UsersIcon class="h-6 w-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Children</p>
              <p class="text-2xl font-bold text-gray-900">{{ children.length }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CheckCircleIcon class="h-6 w-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Active</p>
              <p class="text-2xl font-bold text-gray-900">{{ getChildrenByStatus('active').length }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ClockIcon class="h-6 w-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pending</p>
              <p class="text-2xl font-bold text-gray-900">{{ getChildrenByStatus('pending').length }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
              <XCircleIcon class="h-6 w-6 text-red-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Rejected</p>
              <p class="text-2xl font-bold text-gray-900">{{ getChildrenByStatus('rejected').length }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Children List -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Your Children</h3>
            <div class="flex space-x-2">
              <select 
                v-model="statusFilter" 
                class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
              >
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>
          </div>
        </div>

        <div v-if="isLoading" class="p-8 text-center">
          <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-newradiant-blue"></div>
          <p class="mt-2 text-gray-500">Loading children...</p>
        </div>

        <div v-else-if="filteredChildren.length === 0" class="p-8 text-center">
          <UsersIcon class="h-12 w-12 mx-auto text-gray-400 mb-4" />
          <h3 class="text-lg font-medium text-gray-900 mb-2">No children found</h3>
          <p class="text-gray-500 mb-4">
            {{ children.length === 0 ? "You haven't enrolled any children yet." : "No children match the selected filter." }}
          </p>
          <RouterLink 
            v-if="children.length === 0"
            to="/academy/enroll" 
            class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors"
          >
            Enroll Your First Child
          </RouterLink>
        </div>

        <div v-else class="divide-y divide-gray-200">
          <div 
            v-for="child in filteredChildren" 
            :key="child.id"
            class="p-6 hover:bg-gray-50 transition-colors"
          >
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <!-- Child Avatar -->
                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue flex items-center justify-center">
                  <span class="text-white font-semibold text-lg">{{ getInitials(child.user?.name) }}</span>
                </div>
                
                <!-- Child Info -->
                <div class="flex-1">
                  <div class="flex items-center space-x-3">
                    <h4 class="text-lg font-semibold text-gray-900">{{ child.user?.name }}</h4>
                    <span :class="getStatusBadgeClass(child.enrollment_status)" class="px-2 py-1 rounded-full text-xs font-medium">
                      {{ getStatusText(child.enrollment_status) }}
                    </span>
                  </div>
                  <div class="mt-1 flex items-center space-x-6 text-sm text-gray-500">
                    <span class="flex items-center">
                      <CalendarIcon class="h-4 w-4 mr-1" />
                      Age Group: {{ child.age_group }}
                    </span>
                    <span v-if="child.position" class="flex items-center">
                      <TrophyIcon class="h-4 w-4 mr-1" />
                      {{ child.position }}
                    </span>
                    <span v-if="child.jersey_number" class="flex items-center">
                      <ShieldCheckIcon class="h-4 w-4 mr-1" />
                      #{{ child.jersey_number }}
                    </span>
                  </div>
                  <div v-if="child.experience" class="mt-2 text-sm text-gray-600">
                    <span class="font-medium">Experience:</span> {{ child.experience.substring(0, 100) }}{{ child.experience.length > 100 ? '...' : '' }}
                  </div>
                </div>
              </div>

              <!-- Actions -->
              <div class="flex items-center space-x-2">
                <button 
                  @click="viewChild(child)"
                  class="text-newradiant-blue hover:text-newradiant-dark-blue px-3 py-1 rounded text-sm font-medium"
                >
                  View Details
                </button>
                <button 
                  v-if="child.enrollment_status === 'active'"
                  @click="viewProgress(child)"
                  class="text-green-600 hover:text-green-700 px-3 py-1 rounded text-sm font-medium"
                >
                  View Progress
                </button>
                <button 
                  v-if="child.enrollment_status === 'pending'"
                  @click="editEnrollment(child)"
                  class="text-yellow-600 hover:text-yellow-700 px-3 py-1 rounded text-sm font-medium"
                >
                  Edit
                </button>
              </div>
            </div>

            <!-- Emergency Contact Info -->
            <div v-if="child.emergency_contact_name" class="mt-4 pt-4 border-t border-gray-100">
              <div class="flex items-center text-sm text-gray-600">
                <PhoneIcon class="h-4 w-4 mr-2" />
                <span class="font-medium">Emergency Contact:</span>
                <span class="ml-1">{{ child.emergency_contact_name }} ({{ child.emergency_contact_relation }})</span>
                <span class="ml-2">{{ child.emergency_contact_phone }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <RouterLink 
            to="/academy/enroll" 
            class="bg-white border border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50 transition-colors"
          >
            <svg class="h-8 w-8 mx-auto mb-2 text-newradiant-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <p class="text-sm font-medium">Enroll New Child</p>
          </RouterLink>
          <button 
            @click="viewAllSchedules"
            class="bg-white border border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50 transition-colors"
          >
            <CalendarIcon class="h-8 w-8 mx-auto mb-2 text-green-600" />
            <p class="text-sm font-medium">View All Schedules</p>
          </button>
          <button 
            @click="viewPayments"
            class="bg-white border border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50 transition-colors"
          >
            <CurrencyDollarIcon class="h-8 w-8 mx-auto mb-2 text-yellow-600" />
            <p class="text-sm font-medium">View Payments</p>
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { 
  UsersIcon, 
  CheckCircleIcon, 
  ClockIcon, 
  XCircleIcon,
  CalendarIcon,
  TrophyIcon,
  ShieldCheckIcon,
  PhoneIcon,
  CurrencyDollarIcon
} from '@heroicons/vue/24/outline'
import AdminLayout from '@/components/AdminLayout.vue'
import api from '@/services/api'

const router = useRouter()

const children = ref([])
const isLoading = ref(true)
const statusFilter = ref('')

const filteredChildren = computed(() => {
  if (!statusFilter.value) return children.value
  
  return children.value.filter(child => {
    if (statusFilter.value === 'active') {
      return child.enrollment_status === 'approved' && child.is_active
    } else if (statusFilter.value === 'pending') {
      return child.enrollment_status === 'pending'
    } else if (statusFilter.value === 'rejected') {
      return child.enrollment_status === 'rejected'
    }
    return true
  })
})

const getChildrenByStatus = (status) => {
  if (status === 'active') {
    return children.value.filter(child => child.enrollment_status === 'approved' && child.is_active)
  } else if (status === 'pending') {
    return children.value.filter(child => child.enrollment_status === 'pending')
  } else if (status === 'rejected') {
    return children.value.filter(child => child.enrollment_status === 'rejected')
  }
  return []
}

const getInitials = (name) => {
  if (!name) return 'U'
  return name.split(' ').map(n => n[0]).join('').toUpperCase()
}

const getStatusText = (status) => {
  switch (status) {
    case 'approved': return 'Active'
    case 'pending': return 'Pending Review'
    case 'rejected': return 'Rejected'
    default: return 'Unknown'
  }
}

const getStatusBadgeClass = (status) => {
  switch (status) {
    case 'approved': return 'bg-green-100 text-green-800'
    case 'pending': return 'bg-yellow-100 text-yellow-800'
    case 'rejected': return 'bg-red-100 text-red-800'
    default: return 'bg-gray-100 text-gray-800'
  }
}

const viewChild = (child) => {
  // Navigate to child details page
  console.log('View child:', child)
  // router.push(`/academy/children/${child.id}`)
}

const viewProgress = (child) => {
  // Navigate to child progress page
  console.log('View progress for:', child)
  router.push('/academy/progress')
}

const editEnrollment = (child) => {
  // Navigate to edit enrollment page
  console.log('Edit enrollment for:', child)
  router.push(`/academy/enroll?edit=${child.id}`)
}

const viewAllSchedules = () => {
  router.push('/academy/schedule')
}

const viewPayments = () => {
  router.push('/academy/payments')
}

onMounted(async () => {
  try {
    console.log('Loading children...')
    const response = await api.get('/students/my-children')
    console.log('API Response:', response.data)
    children.value = response.data
  } catch (error) {
    console.error('Failed to load children:', error)
    console.error('Error details:', error.response?.data)
  } finally {
    isLoading.value = false
  }
})
</script>
