<template>
  <AdminLayout>
    <!-- Dashboard Content -->
    <div class="space-y-8">
      <!-- Role-based Dashboard -->
      <div v-if="authStore.isStudent" class="space-y-8">
        <h2 class="text-3xl font-bold text-gray-900">Student Dashboard</h2>
        
        <!-- Student Info Card -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Information</h3>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <p><strong>Name:</strong> {{ authStore.user?.name }}</p>
              <p><strong>Email:</strong> {{ authStore.user?.email }}</p>
              <p><strong>Age Group:</strong> {{ authStore.user?.student?.age_group }}</p>
            </div>
            <div>
              <p><strong>Position:</strong> {{ authStore.user?.student?.position || 'Not assigned' }}</p>
              <p><strong>Jersey Number:</strong> {{ authStore.user?.student?.jersey_number || 'Not assigned' }}</p>
              <p><strong>Guardian:</strong> {{ authStore.user?.student?.guardian?.user?.name }}</p>
            </div>
          </div>
        </div>

        <!-- Upcoming Schedules -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Training Sessions</h3>
          <div v-if="isLoading" class="text-center py-4">
            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-newradiant-blue"></div>
          </div>
          <div v-else-if="schedules.length === 0" class="text-gray-500 text-center py-4">
            No upcoming sessions scheduled
          </div>
          <div v-else class="space-y-3">
            <div 
              v-for="schedule in schedules" 
              :key="schedule.id"
              class="border rounded-lg p-4 hover:bg-gray-50"
            >
              <div class="flex justify-between items-start">
                <div>
                  <h4 class="font-medium text-gray-900">{{ schedule.title }}</h4>
                  <p class="text-sm text-gray-600">{{ schedule.description }}</p>
                  <p class="text-sm text-gray-500">{{ schedule.location }}</p>
                </div>
                <div class="text-right">
                  <p class="text-sm font-medium text-gray-900">{{ new Date(schedule.date).toLocaleDateString() }}</p>
                  <p class="text-sm text-gray-600">{{ schedule.start_time }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Member Dashboard -->
      <div v-else-if="authStore.isMember && !authStore.isAdmin" class="space-y-8">
        <h2 class="text-3xl font-bold text-gray-900">Member Dashboard</h2>
        
        <!-- Fan Card Section -->
        <div class="mb-8">
          <FanCard :user="authStore.user" :enrolled-students="enrolledStudents" />
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                  <UserGroupIcon class="w-5 h-5 text-white" />
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Enrolled Students</p>
                <p class="text-2xl font-semibold text-gray-900">{{ enrolledStudents.length }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                  <CheckCircleIcon class="w-5 h-5 text-white" />
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Active Students</p>
                <p class="text-2xl font-semibold text-gray-900">{{ activeStudents.length }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                  <ClockIcon class="w-5 h-5 text-white" />
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pending Approvals</p>
                <p class="text-2xl font-semibold text-gray-900">{{ pendingStudents.length }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <router-link
              to="/academy/enroll-child"
              class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <UserPlusIcon class="w-6 h-6 text-blue-600" />
                </div>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">Enroll New Child</p>
                <p class="text-sm text-gray-500">Register a new student</p>
              </div>
            </router-link>

            <router-link
              to="/academy/my-children"
              class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                  <UserGroupIcon class="w-6 h-6 text-green-600" />
                </div>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">My Children</p>
                <p class="text-sm text-gray-500">View enrolled students</p>
              </div>
            </router-link>

            <router-link
              to="/academy/schedules"
              class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
            >
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                  <CalendarIcon class="w-6 h-6 text-purple-600" />
                </div>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">Schedules</p>
                <p class="text-sm text-gray-500">View training sessions</p>
              </div>
            </router-link>
          </div>
        </div>
      </div>

      <div v-else-if="authStore.isParent" class="space-y-8">
        <div class="flex justify-between items-center">
          <div>
            <h2 class="text-3xl font-bold text-gray-900">Parent Dashboard</h2>
            <p class="text-gray-600">Manage your children's academy enrollment and progress</p>
          </div>
          <div class="flex space-x-3">
            <RouterLink 
              to="/academy/enroll" 
              class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors font-medium"
            >
              Enroll New Child
            </RouterLink>
            <RouterLink 
              to="/academy/my-children" 
              class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-400 transition-colors font-medium"
            >
              View All Children
            </RouterLink>
          </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <UsersIcon class="h-8 w-8 text-newradiant-blue" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Children</p>
                <p class="text-2xl font-semibold text-gray-900">{{ children.length }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <AcademicCapIcon class="h-8 w-8 text-green-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Active Students</p>
                <p class="text-2xl font-semibold text-gray-900">{{ activeChildren }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <CurrencyDollarIcon class="h-8 w-8 text-yellow-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pending Payments</p>
                <p class="text-2xl font-semibold text-gray-900">{{ pendingPayments }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <CalendarIcon class="h-8 w-8 text-purple-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Upcoming Sessions</p>
                <p class="text-2xl font-semibold text-gray-900">{{ upcomingSessions }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Children Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Children Status Cards -->
          <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
              <h3 class="text-lg font-medium text-gray-900">Your Children</h3>
            </div>
            <div class="p-6">
              <div v-if="children.length === 0" class="text-center py-8">
                <UsersIcon class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                <p class="text-gray-500 mb-4">No children enrolled yet</p>
                <RouterLink 
                  to="/academy/enroll" 
                  class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors"
                >
                  Enroll Your First Child
                </RouterLink>
              </div>
              <div v-else class="space-y-4">
                <div 
                  v-for="child in children.slice(0, 3)" 
                  :key="child.id" 
                  class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
                >
                  <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                      <div class="w-10 h-10 bg-newradiant-blue rounded-full flex items-center justify-center text-white font-semibold">
                        {{ getInitials(child.user?.name) }}
                      </div>
                    </div>
                    <div>
                      <p class="font-medium text-gray-900">{{ child.user?.name }}</p>
                      <p class="text-sm text-gray-500">{{ child.age_group }} • {{ child.position || 'Position TBD' }}</p>
                    </div>
                  </div>
                  <div class="text-right">
                    <span :class="getStatusBadgeClass(child.enrollment_status)" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                      {{ getStatusText(child.enrollment_status) }}
                    </span>
                    <p v-if="child.assigned_coach" class="text-xs text-gray-500 mt-1">
                      Coach: {{ child.assigned_coach.name }}
                    </p>
                  </div>
                </div>
                <div v-if="children.length > 3" class="text-center pt-4">
                  <RouterLink 
                    to="/academy/my-children" 
                    class="text-newradiant-blue hover:text-newradiant-dark-blue text-sm font-medium"
                  >
                    View all {{ children.length }} children →
                  </RouterLink>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Status -->
          <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
              <h3 class="text-lg font-medium text-gray-900">Payment Status</h3>
            </div>
            <div class="p-6">
              <div v-if="paymentRequests.length === 0" class="text-center py-8">
                <CurrencyDollarIcon class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                <p class="text-gray-500">No payment requests</p>
              </div>
              <div v-else class="space-y-4">
                <div 
                  v-for="request in paymentRequests.slice(0, 3)" 
                  :key="request.id" 
                  class="flex items-center justify-between p-4 border border-gray-200 rounded-lg"
                >
                  <div>
                    <p class="font-medium text-gray-900">{{ request.student?.user?.name }}</p>
                    <p class="text-sm text-gray-500">{{ request.description }}</p>
                    <p class="text-sm text-gray-500">{{ request.amount }} {{ request.currency }}</p>
                  </div>
                  <div class="text-right">
                    <span :class="getPaymentStatusBadgeClass(request.status)" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                      {{ getPaymentStatusText(request.status) }}
                    </span>
                    <p class="text-xs text-gray-500 mt-1">
                      Due: {{ new Date(request.due_date).toLocaleDateString() }}
                    </p>
                  </div>
                </div>
                <div v-if="paymentRequests.length > 3" class="text-center pt-4">
                  <button class="text-newradiant-blue hover:text-newradiant-dark-blue text-sm font-medium">
                    View all payments →
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
          </div>
          <div class="p-6">
            <div v-if="recentActivity.length === 0" class="text-center py-8">
              <CalendarIcon class="mx-auto h-12 w-12 text-gray-400 mb-4" />
              <p class="text-gray-500">No recent activity</p>
            </div>
            <div v-else class="space-y-4">
              <div 
                v-for="activity in recentActivity" 
                :key="activity.id" 
                class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg"
              >
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <CalendarIcon class="w-4 h-4 text-blue-600" />
                  </div>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">{{ activity.title }}</p>
                  <p class="text-sm text-gray-500">{{ activity.description }}</p>
                  <p class="text-xs text-gray-400">{{ formatDate(activity.created_at) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else-if="authStore.isCoach || authStore.isAdmin" class="space-y-8">
        <h2 class="text-3xl font-bold text-gray-900">Coach/Admin Dashboard</h2>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Students</h3>
            <p class="text-3xl font-bold text-newradiant-blue">{{ stats.students_count || 0 }}</p>
          </div>
          <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Upcoming Sessions</h3>
            <p class="text-3xl font-bold text-green-600">{{ schedules.length }}</p>
          </div>
          <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Recent Ratings</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ ratings.length }}</p>
          </div>
        </div>

        <!-- Management Actions -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <button class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue">
              Add Student
            </button>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
              Create Schedule
            </button>
            <button class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
              Rate Player
            </button>
            <button class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
              View Reports
            </button>
          </div>
        </div>
      </div>

      <!-- Common Features -->
      <div class="grid md:grid-cols-2 gap-8">
        <!-- Recent News -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Academy News</h3>
          <div v-if="isLoading" class="text-center py-4">
            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-newradiant-blue"></div>
          </div>
          <div v-else-if="academyNews.length === 0" class="text-gray-500">
            No academy news available
          </div>
          <div v-else class="space-y-3">
            <div 
              v-for="article in academyNews" 
              :key="article.id"
              class="border-b pb-3 last:border-b-0"
            >
              <h4 class="font-medium text-gray-900">{{ article.title }}</h4>
              <p class="text-sm text-gray-600">{{ new Date(article.published_at).toLocaleDateString() }}</p>
            </div>
          </div>
        </div>

        <!-- Upcoming Fixtures -->
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Matches</h3>
          <div v-if="isLoading" class="text-center py-4">
            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-newradiant-blue"></div>
          </div>
          <div v-else-if="fixtures.length === 0" class="text-gray-500">
            No upcoming matches
          </div>
          <div v-else class="space-y-3">
            <div 
              v-for="fixture in fixtures" 
              :key="fixture.id"
              class="border-b pb-3 last:border-b-0"
            >
              <h4 class="font-medium text-gray-900">vs {{ fixture.opponent }}</h4>
              <p class="text-sm text-gray-600">{{ fixture.venue }}</p>
              <p class="text-sm text-gray-500">{{ new Date(fixture.match_date).toLocaleDateString() }} at {{ fixture.match_time }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import api from '@/services/api'
import AdminLayout from '@/components/AdminLayout.vue'
import { 
  UsersIcon, 
  AcademicCapIcon, 
  CurrencyDollarIcon, 
  CalendarIcon,
  UserGroupIcon,
  CheckCircleIcon,
  ClockIcon,
  UserPlusIcon
} from '@heroicons/vue/24/outline'
import FanCard from '@/components/FanCard.vue'

const router = useRouter()
const authStore = useAuthStore()

const schedules = ref([])
const fixtures = ref([])
const academyNews = ref([])
const ratings = ref([])
const stats = ref({})
const isLoading = ref(true)

// Parent-specific data
const children = ref([])
const paymentRequests = ref([])
const recentActivity = ref([])

// Member-specific data
const enrolledStudents = ref([])
const loading = ref(false)

// Computed properties for parent dashboard
const activeChildren = computed(() => {
  return children.value.filter(child => child.enrollment_status === 'approved').length
})

const pendingPayments = computed(() => {
  return paymentRequests.value.filter(request => 
    request.status === 'pending' || request.status === 'paid'
  ).length
})

const upcomingSessions = computed(() => {
  return schedules.value.length
})

// Member dashboard computed properties
const activeStudents = computed(() => {
  return enrolledStudents.value.filter(student => student.enrollment_status === 'approved').length
})

const pendingStudents = computed(() => {
  return enrolledStudents.value.filter(student => student.enrollment_status === 'pending').length
})

// Helper methods
const getInitials = (name) => {
  if (!name) return 'U'
  return name.split(' ').map(n => n[0]).join('').toUpperCase()
}

// Fetch enrolled students for members
const fetchEnrolledStudents = async () => {
  try {
    loading.value = true
    const response = await api.get('/my-students')
    enrolledStudents.value = response.data
  } catch (error) {
    console.error('Error fetching enrolled students:', error)
    enrolledStudents.value = []
  } finally {
    loading.value = false
  }
}

const getStatusText = (status) => {
  switch (status) {
    case 'approved': return 'Active'
    case 'pending': return 'Pending'
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

const getPaymentStatusText = (status) => {
  switch (status) {
    case 'pending': return 'Pending'
    case 'paid': return 'Paid'
    case 'verified': return 'Verified'
    case 'rejected': return 'Rejected'
    default: return 'Unknown'
  }
}

const getPaymentStatusBadgeClass = (status) => {
  switch (status) {
    case 'pending': return 'bg-yellow-100 text-yellow-800'
    case 'paid': return 'bg-blue-100 text-blue-800'
    case 'verified': return 'bg-green-100 text-green-800'
    case 'rejected': return 'bg-red-100 text-red-800'
    default: return 'bg-gray-100 text-gray-800'
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString()
}

// Load parent-specific data
const loadParentData = async () => {
  try {
    // Load children
    const childrenResponse = await api.get('/students/my-children')
    children.value = childrenResponse.data

    // Load payment requests
    const paymentsResponse = await api.get('/payment-requests/my-requests')
    paymentRequests.value = paymentsResponse.data

    // Generate recent activity (mock data for now)
    recentActivity.value = [
      {
        id: 1,
        title: 'Child enrollment submitted',
        description: 'Your child\'s enrollment is under review',
        created_at: new Date().toISOString()
      },
      {
        id: 2,
        title: 'Payment received',
        description: 'Payment for academy fees has been processed',
        created_at: new Date(Date.now() - 86400000).toISOString()
      }
    ]
  } catch (error) {
    console.error('Failed to load parent data:', error)
  }
}

onMounted(async () => {
  // Fetch member data if user is a member
  if (authStore.isMember && !authStore.isAdmin) {
    await fetchEnrolledStudents()
    return
  }

  try {
    const response = await api.get('/dashboard')
    const data = response.data
    
    schedules.value = data.upcoming_schedules || []
    fixtures.value = data.upcoming_schedules || [] // This should be fixtures in real implementation
    academyNews.value = []
    ratings.value = data.recent_ratings || []
    stats.value = data

    // Load parent-specific data if user is a parent
    if (authStore.isParent) {
      await loadParentData()
    }
  } catch (error) {
    console.error('Failed to load dashboard data:', error)
  } finally {
    isLoading.value = false
  }
})
</script>
