<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Training Schedules</h1>
          <p class="text-gray-600">Manage training sessions and schedules</p>
        </div>
        <button class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors">
          Create New Schedule
        </button>
      </div>

      <!-- Calendar View Toggle -->
      <div class="flex justify-between items-center">
        <div class="flex space-x-4">
          <button 
            :class="[viewMode === 'list' ? 'bg-newradiant-blue text-white' : 'bg-gray-200 text-gray-700', 'px-4 py-2 rounded-lg']"
            @click="viewMode = 'list'"
          >
            List View
          </button>
          <button 
            :class="[viewMode === 'calendar' ? 'bg-newradiant-blue text-white' : 'bg-gray-200 text-gray-700', 'px-4 py-2 rounded-lg']"
            @click="viewMode = 'calendar'"
          >
            Calendar View
          </button>
        </div>
        <div class="text-sm text-gray-500">
          {{ schedules.length }} upcoming sessions
        </div>
      </div>

      <!-- List View -->
      <div v-if="viewMode === 'list'" class="space-y-6">
        <div 
          v-for="schedule in schedules" 
          :key="schedule.id"
          class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow"
        >
          <div class="flex justify-between items-start">
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900">{{ schedule.title }}</h3>
              <p class="text-gray-600 mt-1">{{ schedule.description }}</p>
              <div class="flex items-center mt-3 space-x-6 text-sm text-gray-500">
                <div class="flex items-center">
                  <CalendarIcon class="h-4 w-4 mr-2" />
                  {{ new Date(schedule.date).toLocaleDateString() }}
                </div>
                <div class="flex items-center">
                  <ClockIcon class="h-4 w-4 mr-2" />
                  {{ schedule.start_time }} - {{ schedule.end_time }}
                </div>
                <div class="flex items-center">
                  <MapPinIcon class="h-4 w-4 mr-2" />
                  {{ schedule.location }}
                </div>
                <div class="flex items-center">
                  <UsersIcon class="h-4 w-4 mr-2" />
                  {{ schedule.age_group }}
                </div>
              </div>
            </div>
            <div class="flex space-x-2 ml-4">
              <button class="text-newradiant-blue hover:text-newradiant-dark-blue px-3 py-1 rounded">
                Edit
              </button>
              <button class="text-red-600 hover:text-red-900 px-3 py-1 rounded">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Calendar View -->
      <div v-else class="bg-white rounded-lg shadow p-6">
        <div class="text-center text-gray-500 py-12">
          <CalendarIcon class="h-12 w-12 mx-auto mb-4 text-gray-400" />
          <p>Calendar view coming soon...</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <button class="bg-white border border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50">
            <CalendarIcon class="h-8 w-8 mx-auto mb-2 text-newradiant-blue" />
            <p class="text-sm font-medium">Weekly Schedule</p>
          </button>
          <button class="bg-white border border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50">
            <UsersIcon class="h-8 w-8 mx-auto mb-2 text-green-600" />
            <p class="text-sm font-medium">Group Training</p>
          </button>
          <button class="bg-white border border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50">
            <TrophyIcon class="h-8 w-8 mx-auto mb-2 text-yellow-600" />
            <p class="text-sm font-medium">Match Day</p>
          </button>
          <button class="bg-white border border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50">
            <AcademicCapIcon class="h-8 w-8 mx-auto mb-2 text-purple-600" />
            <p class="text-sm font-medium">Special Session</p>
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { 
  CalendarIcon, 
  ClockIcon, 
  MapPinIcon, 
  UsersIcon, 
  TrophyIcon, 
  AcademicCapIcon 
} from '@heroicons/vue/24/outline'
import AdminLayout from '@/components/AdminLayout.vue'
import api from '@/services/api'

const schedules = ref([])
const viewMode = ref('list')
const isLoading = ref(true)

onMounted(async () => {
  try {
    const response = await api.get('/schedules')
    schedules.value = response.data
  } catch (error) {
    console.error('Failed to load schedules:', error)
  } finally {
    isLoading.value = false
  }
})
</script>
