<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Meta Tags -->
    <MetaTags
      title="Member Dashboard - New Radiant SC"
      description="View your enrolled students and member activities"
      image="/og-academy.svg"
      type="website"
      url="/member-dashboard"
    />

    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Member Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ user?.name }}</p>
          </div>
          <div class="flex items-center space-x-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
              {{ user?.role }}
            </span>
            <button
              @click="logout"
              class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Fan Card Section -->
      <div class="mb-8">
        <FanCard :user="user" :enrolled-students="enrolledStudents" />
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

      <!-- Tabs -->
      <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8 px-6">
            <button
              @click="activeTab = 'students'"
              :class="[
                activeTab === 'students'
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
              ]"
            >
              My Students
            </button>
            <button
              @click="activeTab = 'activities'"
              :class="[
                activeTab === 'activities'
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
              ]"
            >
              Activities
            </button>
            <button
              @click="activeTab = 'enroll'"
              :class="[
                activeTab === 'enroll'
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
              ]"
            >
              Enroll New Student
            </button>
          </nav>
        </div>

        <div class="p-6">
          <!-- Students Tab -->
          <div v-if="activeTab === 'students'" class="space-y-6">
            <div class="flex justify-between items-center">
              <h3 class="text-lg font-medium text-gray-900">My Enrolled Students</h3>
              <button
                @click="activeTab = 'enroll'"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700"
              >
                Enroll New Student
              </button>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="text-center py-8">
              <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
              <p class="mt-2 text-gray-600">Loading students...</p>
            </div>

            <!-- Students List -->
            <div v-else-if="enrolledStudents.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div
                v-for="student in enrolledStudents"
                :key="student.id"
                class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow"
              >
                <div class="flex items-center justify-between mb-4">
                  <h4 class="text-lg font-semibold text-gray-900">{{ student.user.name }}</h4>
                  <span
                    :class="[
                      'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                      student.enrollment_status === 'approved'
                        ? 'bg-green-100 text-green-800'
                        : student.enrollment_status === 'pending'
                        ? 'bg-yellow-100 text-yellow-800'
                        : 'bg-red-100 text-red-800'
                    ]"
                  >
                    {{ student.enrollment_status }}
                  </span>
                </div>

                <div class="space-y-2 text-sm text-gray-600">
                  <p><span class="font-medium">Age Group:</span> {{ student.age_group }}</p>
                  <p><span class="font-medium">Position:</span> {{ student.position || 'Not assigned' }}</p>
                  <p><span class="font-medium">Jersey Number:</span> {{ student.jersey_number || 'Not assigned' }}</p>
                  <p v-if="student.assigned_coach"><span class="font-medium">Coach:</span> {{ student.assigned_coach.name }}</p>
                </div>

                <div class="mt-4 flex space-x-2">
                  <button
                    @click="viewStudent(student)"
                    class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                  >
                    View Details
                  </button>
                </div>
              </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
              <UserGroupIcon class="mx-auto h-12 w-12 text-gray-400" />
              <h3 class="mt-2 text-sm font-medium text-gray-900">No students enrolled</h3>
              <p class="mt-1 text-sm text-gray-500">Get started by enrolling a new student.</p>
              <div class="mt-6">
                <button
                  @click="activeTab = 'enroll'"
                  class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
                >
                  Enroll New Student
                </button>
              </div>
            </div>
          </div>

          <!-- Activities Tab -->
          <div v-else-if="activeTab === 'activities'" class="space-y-6">
            <h3 class="text-lg font-medium text-gray-900">Recent Activities</h3>
            <div class="text-center py-12">
              <ClockIcon class="mx-auto h-12 w-12 text-gray-400" />
              <h3 class="mt-2 text-sm font-medium text-gray-900">No activities yet</h3>
              <p class="mt-1 text-sm text-gray-500">Activities will appear here as they happen.</p>
            </div>
          </div>

          <!-- Enroll Tab -->
          <div v-else-if="activeTab === 'enroll'" class="space-y-6">
            <h3 class="text-lg font-medium text-gray-900">Enroll New Student</h3>
            <p class="text-gray-600">Fill out the form below to enroll a new student in our academy.</p>
            
            <!-- Enroll Form Component -->
            <EnrollChildView @student-enrolled="handleStudentEnrolled" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import MetaTags from '@/components/MetaTags.vue'
import FanCard from '@/components/FanCard.vue'
import EnrollChildView from '@/views/EnrollChildView.vue'
import { UserGroupIcon, CheckCircleIcon, ClockIcon } from '@heroicons/vue/24/outline'

const router = useRouter()

// State
const user = ref(null)
const enrolledStudents = ref([])
const loading = ref(true)
const activeTab = ref('students')

// Computed
const activeStudents = computed(() => 
  enrolledStudents.value.filter(student => student.enrollment_status === 'approved' && student.is_active)
)

const pendingStudents = computed(() => 
  enrolledStudents.value.filter(student => student.enrollment_status === 'pending')
)

// Methods
const fetchUser = async () => {
  try {
    const response = await api.get('/user')
    user.value = response.data
  } catch (error) {
    console.error('Error fetching user:', error)
    router.push('/login')
  }
}

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

const viewStudent = (student) => {
  // Navigate to student details page
  router.push(`/student/${student.id}`)
}

const handleStudentEnrolled = (student) => {
  // Add the new student to the list
  enrolledStudents.value.unshift(student)
  // Switch back to students tab
  activeTab.value = 'students'
}

const logout = async () => {
  try {
    await api.post('/logout')
    localStorage.removeItem('token')
    router.push('/')
  } catch (error) {
    console.error('Error logging out:', error)
  }
}

// Lifecycle
onMounted(async () => {
  await fetchUser()
  await fetchEnrolledStudents()
})
</script>
