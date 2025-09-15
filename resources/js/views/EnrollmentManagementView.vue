<template>
  <AdminLayout>
    <div class="p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Enrollment Management</h1>
        <p class="text-gray-600">Manage student enrollment applications</p>
      </div>

      <!-- Filters and Search -->
      <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search by name..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              @input="debouncedSearch"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              v-model="statusFilter"
              @change="fetchEnrollments"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">All Status</option>
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="flex items-end">
            <button
              @click="fetchEnrollments"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Refresh
            </button>
          </div>
        </div>
      </div>

      <!-- Enrollments Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Student
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Parent/Guardian
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Contact
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Applied
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-if="loading" class="text-center">
                <td colspan="6" class="px-6 py-4">
                  <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                  </div>
                </td>
              </tr>
              <tr v-else-if="enrollments.length === 0">
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                  No enrollments found
                </td>
              </tr>
              <tr v-else v-for="enrollment in enrollments" :key="enrollment.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div v-if="enrollment.photograph_path" class="flex-shrink-0 h-10 w-10">
                      <img
                        :src="`/storage/${enrollment.photograph_path}`"
                        :alt="enrollment.full_name"
                        class="h-10 w-10 rounded-full object-cover"
                      />
                    </div>
                    <div v-else class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                      <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ enrollment.full_name }}</div>
                      <div class="text-sm text-gray-500">{{ enrollment.date_of_birth }} ({{ enrollment.gender }})</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ enrollment.parent_name }}</div>
                  <div class="text-sm text-gray-500">{{ enrollment.parent_telephone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ enrollment.telephone_no }}</div>
                  <div class="text-sm text-gray-500">{{ enrollment.nationality }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="{
                      'bg-yellow-100 text-yellow-800': enrollment.status === 'pending',
                      'bg-green-100 text-green-800': enrollment.status === 'approved',
                      'bg-red-100 text-red-800': enrollment.status === 'rejected'
                    }"
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  >
                    {{ enrollment.status.charAt(0).toUpperCase() + enrollment.status.slice(1) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(enrollment.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button
                      @click="viewEnrollment(enrollment)"
                      class="text-blue-600 hover:text-blue-900"
                    >
                      View
                    </button>
                    <button
                      @click="editEnrollment(enrollment)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Edit
                    </button>
                    <button
                      @click="deleteEnrollment(enrollment)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="pagination" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="flex-1 flex justify-between sm:hidden">
            <button
              v-if="pagination.prev_page_url"
              @click="fetchEnrollments(pagination.current_page - 1)"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Previous
            </button>
            <button
              v-if="pagination.next_page_url"
              @click="fetchEnrollments(pagination.current_page + 1)"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ pagination.from }}</span>
                to
                <span class="font-medium">{{ pagination.to }}</span>
                of
                <span class="font-medium">{{ pagination.total }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <button
                  v-if="pagination.prev_page_url"
                  @click="fetchEnrollments(pagination.current_page - 1)"
                  class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                >
                  Previous
                </button>
                <button
                  v-if="pagination.next_page_url"
                  @click="fetchEnrollments(pagination.current_page + 1)"
                  class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                >
                  Next
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- View/Edit Modal -->
      <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white" @click.stop>
          <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-medium text-gray-900">
                {{ isEditing ? 'Edit' : 'View' }} Enrollment
              </h3>
              <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <div v-if="selectedEnrollment" class="space-y-6">
              <!-- Student Information -->
              <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-3">Student Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.full_name }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.date_of_birth }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.gender }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">ID Number</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.id_number || 'N/A' }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Nationality</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.nationality }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">School</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.school_attended }}</p>
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.home_address }}</p>
                  </div>
                </div>
              </div>

              <!-- Parent Information -->
              <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-3">Parent/Guardian Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.parent_name }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Telephone</label>
                    <p class="text-sm text-gray-900">{{ selectedEnrollment.parent_telephone }}</p>
                  </div>
                </div>
              </div>

              <!-- Office Use Section -->
              <div class="bg-blue-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-3">Office Use</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select
                      v-if="isEditing"
                      v-model="editForm.status"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                      <option value="pending">Pending</option>
                      <option value="approved">Approved</option>
                      <option value="rejected">Rejected</option>
                    </select>
                    <p v-else class="text-sm text-gray-900">{{ selectedEnrollment.status }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Application Received By</label>
                    <input
                      v-if="isEditing"
                      v-model="editForm.application_received_by"
                      type="text"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-else class="text-sm text-gray-900">{{ selectedEnrollment.application_received_by || 'N/A' }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Registration Number</label>
                    <input
                      v-if="isEditing"
                      v-model="editForm.reg_no"
                      type="text"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-else class="text-sm text-gray-900">{{ selectedEnrollment.reg_no || 'N/A' }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Squad</label>
                    <input
                      v-if="isEditing"
                      v-model="editForm.squad"
                      type="text"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-else class="text-sm text-gray-900">{{ selectedEnrollment.squad || 'N/A' }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Centre</label>
                    <input
                      v-if="isEditing"
                      v-model="editForm.centre"
                      type="text"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-else class="text-sm text-gray-900">{{ selectedEnrollment.centre || 'N/A' }}</p>
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea
                      v-if="isEditing"
                      v-model="editForm.remarks"
                      rows="3"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                    <p v-else class="text-sm text-gray-900">{{ selectedEnrollment.remarks || 'N/A' }}</p>
                  </div>
                </div>
              </div>

              <!-- Actions -->
              <div class="flex justify-end space-x-3">
                <button
                  v-if="!isEditing"
                  @click="isEditing = true"
                  class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  Edit
                </button>
                <button
                  v-if="isEditing"
                  @click="saveEnrollment"
                  :disabled="saving"
                  class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50"
                >
                  {{ saving ? 'Saving...' : 'Save Changes' }}
                </button>
                <button
                  @click="closeModal"
                  class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                  {{ isEditing ? 'Cancel' : 'Close' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import AdminLayout from '../components/AdminLayout.vue'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()

const enrollments = ref([])
const loading = ref(false)
const searchQuery = ref('')
const statusFilter = ref('')
const pagination = ref(null)
const showModal = ref(false)
const selectedEnrollment = ref(null)
const isEditing = ref(false)
const saving = ref(false)

const editForm = ref({
  status: '',
  application_received_by: '',
  reg_no: '',
  squad: '',
  centre: '',
  remarks: ''
})

let searchTimeout = null

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchEnrollments()
  }, 500)
}

const fetchEnrollments = async (page = 1) => {
  loading.value = true
  try {
    const params = new URLSearchParams({
      page: page.toString()
    })
    
    if (searchQuery.value) {
      params.append('search', searchQuery.value)
    }
    
    if (statusFilter.value) {
      params.append('status', statusFilter.value)
    }

    const response = await fetch(`/api/enrollments?${params}`, {
      headers: {
        'Authorization': `Bearer ${authStore.token}`,
        'Accept': 'application/json'
      }
    })

    if (response.ok) {
      const data = await response.json()
      enrollments.value = data.data
      pagination.value = {
        current_page: data.current_page,
        last_page: data.last_page,
        from: data.from,
        to: data.to,
        total: data.total,
        prev_page_url: data.prev_page_url,
        next_page_url: data.next_page_url
      }
    } else {
      console.error('Failed to fetch enrollments')
    }
  } catch (error) {
    console.error('Error fetching enrollments:', error)
  } finally {
    loading.value = false
  }
}

const viewEnrollment = (enrollment) => {
  selectedEnrollment.value = enrollment
  isEditing.value = false
  showModal.value = true
}

const editEnrollment = (enrollment) => {
  selectedEnrollment.value = enrollment
  isEditing.value = true
  editForm.value = {
    status: enrollment.status,
    application_received_by: enrollment.application_received_by || '',
    reg_no: enrollment.reg_no || '',
    squad: enrollment.squad || '',
    centre: enrollment.centre || '',
    remarks: enrollment.remarks || ''
  }
  showModal.value = true
}

const saveEnrollment = async () => {
  saving.value = true
  try {
    const response = await fetch(`/api/enrollments/${selectedEnrollment.value.id}`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${authStore.token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(editForm.value)
    })

    if (response.ok) {
      const data = await response.json()
      if (data.success) {
        // Update the enrollment in the list
        const index = enrollments.value.findIndex(e => e.id === selectedEnrollment.value.id)
        if (index !== -1) {
          enrollments.value[index] = { ...enrollments.value[index], ...editForm.value }
        }
        closeModal()
      } else {
        console.error('Failed to update enrollment:', data.message)
      }
    } else {
      console.error('Failed to update enrollment')
    }
  } catch (error) {
    console.error('Error updating enrollment:', error)
  } finally {
    saving.value = false
  }
}

const deleteEnrollment = async (enrollment) => {
  if (confirm('Are you sure you want to delete this enrollment?')) {
    try {
      const response = await fetch(`/api/enrollments/${enrollment.id}`, {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${authStore.token}`,
          'Accept': 'application/json'
        }
      })

      if (response.ok) {
        const data = await response.json()
        if (data.success) {
          // Remove from list
          const index = enrollments.value.findIndex(e => e.id === enrollment.id)
          if (index !== -1) {
            enrollments.value.splice(index, 1)
          }
        } else {
          console.error('Failed to delete enrollment:', data.message)
        }
      } else {
        console.error('Failed to delete enrollment')
      }
    } catch (error) {
      console.error('Error deleting enrollment:', error)
    }
  }
}

const closeModal = () => {
  showModal.value = false
  selectedEnrollment.value = null
  isEditing.value = false
  editForm.value = {
    status: '',
    application_received_by: '',
    reg_no: '',
    squad: '',
    centre: '',
    remarks: ''
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

onMounted(() => {
  fetchEnrollments()
})
</script>
