<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Students Management</h1>
          <p class="text-gray-600">Manage academy students and their information</p>
        </div>
        <div class="flex space-x-3">
          <button 
            @click="showPaymentRequestModal = true"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors"
          >
            Request Payment
          </button>
          <button 
            @click="showAddStudentModal = true"
            class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors"
          >
            Add New Student
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <UsersIcon class="h-6 w-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Students</p>
              <p class="text-2xl font-bold text-gray-900">{{ students.length }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <AcademicCapIcon class="h-6 w-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">U-12 Players</p>
              <p class="text-2xl font-bold text-gray-900">{{ getStudentsByAgeGroup('U-12').length }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <AcademicCapIcon class="h-6 w-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">U-15 Players</p>
              <p class="text-2xl font-bold text-gray-900">{{ getStudentsByAgeGroup('U-15').length }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
              <AcademicCapIcon class="h-6 w-6 text-purple-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">U-18 Players</p>
              <p class="text-2xl font-bold text-gray-900">{{ getStudentsByAgeGroup('U-18').length }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Students Table -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">All Students</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age Group</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guardian</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="student in students" :key="student.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue flex items-center justify-center">
                      <span class="text-white font-semibold text-sm">{{ getInitials(student.user?.name) }}</span>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ student.user?.name }}</div>
                      <div class="text-sm text-gray-500">{{ student.user?.email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ student.age_group }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ student.position || 'Not assigned' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ student.guardian?.user?.name || 'Not assigned' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(student.enrollment_status)" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ getStatusText(student.enrollment_status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div v-if="student.payment_requests && student.payment_requests.length > 0">
                    <span :class="getPaymentStatusBadgeClass(student.payment_requests[0].status)" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                      {{ getPaymentStatusText(student.payment_requests[0].status) }}
                    </span>
                    <div class="text-xs text-gray-500 mt-1">
                      {{ student.payment_requests[0].amount }} {{ student.payment_requests[0].currency }}
                    </div>
                  </div>
                  <span v-else class="text-gray-400 text-xs">No payment</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button 
                      v-if="student.enrollment_status === 'pending' && (!student.payment_requests || student.payment_requests.length === 0)"
                      @click="requestPayment(student)"
                      class="text-green-600 hover:text-green-700 px-2 py-1 rounded text-xs"
                    >
                      Request Payment
                    </button>
                    <button 
                      v-if="student.enrollment_status === 'pending' && hasVerifiedPayment(student)"
                      @click="approveStudent(student)"
                      class="text-blue-600 hover:text-blue-700 px-2 py-1 rounded text-xs"
                    >
                      Approve
                    </button>
                    <button 
                      v-if="student.enrollment_status === 'approved' && !student.assigned_coach_id"
                      @click="assignCoach(student)"
                      class="text-purple-600 hover:text-purple-700 px-2 py-1 rounded text-xs"
                    >
                      Assign Coach
                    </button>
                    <button class="text-newradiant-blue hover:text-newradiant-dark-blue px-2 py-1 rounded text-xs">Edit</button>
                    <button class="text-red-600 hover:text-red-900 px-2 py-1 rounded text-xs">Delete</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Payment Request Modal -->
    <div v-if="showPaymentRequestModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Request Payment</h3>
          
          <form @submit.prevent="submitPaymentRequest">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                <select 
                  v-model="paymentForm.student_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  required
                >
                  <option value="">Choose a student</option>
                  <option 
                    v-for="student in students.filter(s => s.enrollment_status === 'pending')" 
                    :key="student.id" 
                    :value="student.id"
                  >
                    {{ student.user?.name }} ({{ student.age_group }})
                  </option>
                </select>
              </div>
              
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                  <input 
                    v-model="paymentForm.amount"
                    type="number" 
                    step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                  <select 
                    v-model="paymentForm.currency"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  >
                    <option value="MVR">MVR</option>
                    <option value="USD">USD</option>
                  </select>
                </div>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea 
                  v-model="paymentForm.description"
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  required
                ></textarea>
              </div>
              
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                  <input 
                    v-model="paymentForm.account_number"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                  <input 
                    v-model="paymentForm.bank_name"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                <input 
                  v-model="paymentForm.due_date"
                  type="date"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  required
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Admin Notes</label>
                <textarea 
                  v-model="paymentForm.admin_notes"
                  rows="2"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                ></textarea>
              </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
              <button 
                type="button"
                @click="showPaymentRequestModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
              >
                Cancel
              </button>
              <button 
                type="submit"
                :disabled="isSubmitting"
                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50"
              >
                {{ isSubmitting ? 'Creating...' : 'Create Request' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Coach Assignment Modal -->
    <div v-if="showCoachModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Coach</h3>
          
          <form @submit.prevent="submitCoachAssignment">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                <input 
                  :value="selectedStudent?.user?.name"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50"
                  readonly
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Coach</label>
                <select 
                  v-model="coachForm.coach_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  required
                >
                  <option value="">Choose a coach</option>
                  <option 
                    v-for="coach in coaches" 
                    :key="coach.id" 
                    :value="coach.id"
                  >
                    {{ coach.name }}
                  </option>
                </select>
              </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
              <button 
                type="button"
                @click="showCoachModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
              >
                Cancel
              </button>
              <button 
                type="submit"
                :disabled="isSubmitting"
                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 disabled:opacity-50"
              >
                {{ isSubmitting ? 'Assigning...' : 'Assign Coach' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { UsersIcon, AcademicCapIcon } from '@heroicons/vue/24/outline'
import AdminLayout from '@/components/AdminLayout.vue'
import api from '@/services/api'

const students = ref([])
const coaches = ref([])
const isLoading = ref(true)
const isSubmitting = ref(false)

// Modal states
const showPaymentRequestModal = ref(false)
const showCoachModal = ref(false)
const selectedStudent = ref(null)

// Form data
const paymentForm = ref({
  student_id: '',
  amount: '',
  currency: 'MVR',
  description: '',
  account_number: '',
  bank_name: '',
  due_date: '',
  admin_notes: ''
})

const coachForm = ref({
  coach_id: ''
})

const getStudentsByAgeGroup = (ageGroup) => {
  return students.value.filter(student => student.age_group === ageGroup)
}

const getInitials = (name) => {
  if (!name) return 'U'
  return name.split(' ').map(n => n[0]).join('').toUpperCase()
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

const hasVerifiedPayment = (student) => {
  return student.payment_requests?.some(pr => pr.status === 'verified')
}

const requestPayment = (student) => {
  paymentForm.value.student_id = student.id
  showPaymentRequestModal.value = true
}

const assignCoach = (student) => {
  selectedStudent.value = student
  coachForm.value.coach_id = ''
  showCoachModal.value = true
}

const submitPaymentRequest = async () => {
  isSubmitting.value = true
  
  try {
    const response = await api.post(`/students/${paymentForm.value.student_id}/request-payment`, paymentForm.value)
    
    // Reset form
    paymentForm.value = {
      student_id: '',
      amount: '',
      currency: 'MVR',
      description: '',
      account_number: '',
      bank_name: '',
      due_date: '',
      admin_notes: ''
    }
    
    showPaymentRequestModal.value = false
    await loadStudents() // Reload students to show updated data
    
    alert('Payment request created successfully!')
  } catch (error) {
    console.error('Failed to create payment request:', error)
    alert('Failed to create payment request. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const approveStudent = async (student) => {
  if (!confirm(`Are you sure you want to approve ${student.user?.name}?`)) return
  
  isSubmitting.value = true
  
  try {
    const response = await api.post(`/students/${student.id}/approve`, {
      approval_notes: 'Approved via admin panel'
    })
    
    await loadStudents() // Reload students to show updated data
    alert('Student approved successfully!')
  } catch (error) {
    console.error('Failed to approve student:', error)
    alert('Failed to approve student. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const submitCoachAssignment = async () => {
  isSubmitting.value = true
  
  try {
    const response = await api.post(`/students/${selectedStudent.value.id}/assign-coach`, coachForm.value)
    
    showCoachModal.value = false
    await loadStudents() // Reload students to show updated data
    
    alert('Coach assigned successfully!')
  } catch (error) {
    console.error('Failed to assign coach:', error)
    alert('Failed to assign coach. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const loadStudents = async () => {
  try {
    const response = await api.get('/students')
    students.value = response.data
  } catch (error) {
    console.error('Failed to load students:', error)
  }
}

const loadCoaches = async () => {
  try {
    const response = await api.get('/users?role=coach')
    coaches.value = response.data
  } catch (error) {
    console.error('Failed to load coaches:', error)
  }
}

onMounted(async () => {
  await Promise.all([
    loadStudents(),
    loadCoaches()
  ])
  isLoading.value = false
})
</script>
