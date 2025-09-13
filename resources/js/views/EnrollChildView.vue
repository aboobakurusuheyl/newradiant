<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Enroll Your Child</h1>
          <p class="text-gray-600">Register your child for New Radiant Sports Club Academy</p>
        </div>
        <RouterLink 
          to="/academy" 
          class="text-newradiant-blue hover:text-newradiant-dark-blue font-medium"
        >
          ← Back to Dashboard
        </RouterLink>
      </div>

      <!-- Enrollment Steps -->
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-8">
          <div class="flex items-center space-x-4">
            <div :class="[currentStep >= 1 ? 'bg-newradiant-blue text-white' : 'bg-gray-200 text-gray-600', 'w-8 h-8 rounded-full flex items-center justify-center font-semibold']">
              1
            </div>
            <span :class="[currentStep >= 1 ? 'text-gray-900' : 'text-gray-500', 'font-medium']">Child Information</span>
          </div>
          <div class="flex-1 mx-4 h-0.5 bg-gray-200">
            <div :class="[currentStep >= 2 ? 'bg-newradiant-blue' : 'bg-gray-200', 'h-full transition-all duration-300']"></div>
          </div>
          <div class="flex items-center space-x-4">
            <div :class="[currentStep >= 2 ? 'bg-newradiant-blue text-white' : 'bg-gray-200 text-gray-600', 'w-8 h-8 rounded-full flex items-center justify-center font-semibold']">
              2
            </div>
            <span :class="[currentStep >= 2 ? 'text-gray-900' : 'text-gray-500', 'font-medium']">Medical & Emergency</span>
          </div>
          <div class="flex-1 mx-4 h-0.5 bg-gray-200">
            <div :class="[currentStep >= 3 ? 'bg-newradiant-blue' : 'bg-gray-200', 'h-full transition-all duration-300']"></div>
          </div>
          <div class="flex items-center space-x-4">
            <div :class="[currentStep >= 3 ? 'bg-newradiant-blue text-white' : 'bg-gray-200 text-gray-600', 'w-8 h-8 rounded-full flex items-center justify-center font-semibold']">
              3
            </div>
            <span :class="[currentStep >= 3 ? 'text-gray-900' : 'text-gray-500', 'font-medium']">Payment</span>
          </div>
          <div class="flex-1 mx-4 h-0.5 bg-gray-200">
            <div :class="[currentStep >= 4 ? 'bg-newradiant-blue' : 'bg-gray-200', 'h-full transition-all duration-300']"></div>
          </div>
          <div class="flex items-center space-x-4">
            <div :class="[currentStep >= 4 ? 'bg-newradiant-blue text-white' : 'bg-gray-200 text-gray-600', 'w-8 h-8 rounded-full flex items-center justify-center font-semibold']">
              4
            </div>
            <span :class="[currentStep >= 4 ? 'text-gray-900' : 'text-gray-500', 'font-medium']">Review & Submit</span>
          </div>
        </div>

        <!-- Step 1: Child Information -->
        <div v-if="currentStep === 1" class="space-y-6">
          <h3 class="text-xl font-semibold text-gray-900">Child's Personal Information</h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
              <input 
                v-model="formData.childName"
                type="text" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                placeholder="Enter child's full name"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
              <input 
                v-model="formData.dateOfBirth"
                type="date" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
              <select 
                v-model="formData.gender"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                required
              >
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Age Group *</label>
              <select 
                v-model="formData.ageGroup"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                required
              >
                <option value="">Select Age Group</option>
                <option value="U-12">U-12 (Under 12)</option>
                <option value="U-15">U-15 (Under 15)</option>
                <option value="U-18">U-18 (Under 18)</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Position</label>
              <select 
                v-model="formData.preferredPosition"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
              >
                <option value="">Select Position</option>
                <option value="goalkeeper">Goalkeeper</option>
                <option value="defender">Defender</option>
                <option value="midfielder">Midfielder</option>
                <option value="forward">Forward</option>
                <option value="any">Any Position</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Jersey Number Preference</label>
              <input 
                v-model="formData.jerseyNumber"
                type="number" 
                min="1" 
                max="99"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                placeholder="Enter preferred number"
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Previous Football Experience</label>
            <textarea 
              v-model="formData.experience"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
              placeholder="Describe any previous football experience, clubs, or training..."
            ></textarea>
          </div>
        </div>

        <!-- Step 2: Medical & Emergency Information -->
        <div v-if="currentStep === 2" class="space-y-6">
          <h3 class="text-xl font-semibold text-gray-900">Medical & Emergency Information</h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Medical Conditions</label>
              <textarea 
                v-model="formData.medicalConditions"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                placeholder="List any medical conditions, allergies, or medications..."
              ></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Name *</label>
              <input 
                v-model="formData.emergencyContactName"
                type="text" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                placeholder="Emergency contact full name"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Phone *</label>
              <input 
                v-model="formData.emergencyContactPhone"
                type="tel" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                placeholder="+960 123-4567"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Relationship to Child *</label>
              <select 
                v-model="formData.emergencyContactRelation"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                required
              >
                <option value="">Select Relationship</option>
                <option value="parent">Parent</option>
                <option value="guardian">Guardian</option>
                <option value="grandparent">Grandparent</option>
                <option value="sibling">Sibling</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>

          <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Medical Information</h3>
                <div class="mt-2 text-sm text-blue-700">
                  <p>Please provide accurate medical information to ensure your child's safety during training and matches. This information will be kept confidential and only shared with coaching staff when necessary.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 3: Payment Details -->
        <div v-if="currentStep === 3" class="space-y-6">
          <h3 class="text-xl font-semibold text-gray-900">Payment Information</h3>
          
          <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Academy Fees</h3>
                <div class="mt-2 text-sm text-blue-700">
                  <p>To complete your child's enrollment, please make the required payment and upload the receipt. The enrollment will be reviewed once payment is verified.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Payment Amount (MVR) *</label>
              <input 
                v-model="formData.paymentAmount"
                type="number" 
                step="0.01"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                placeholder="Enter payment amount"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
              <select 
                v-model="formData.paymentMethod"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                required
              >
                <option value="">Select Payment Method</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="mobile_payment">Mobile Payment</option>
                <option value="cash">Cash</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Reference</label>
              <input 
                v-model="formData.transactionReference"
                type="text" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                placeholder="Enter transaction reference (if applicable)"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date *</label>
              <input 
                v-model="formData.paymentDate"
                type="date" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                required
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Receipt *</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
              <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                  <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                  <label for="receipt-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-newradiant-blue hover:text-newradiant-dark-blue focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-newradiant-blue">
                    <span>Upload a file</span>
                    <input 
                      id="receipt-upload" 
                      ref="receiptInput"
                      type="file" 
                      accept="image/*,.pdf"
                      @change="handleReceiptUpload"
                      class="sr-only"
                    />
                  </label>
                  <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, PDF up to 2MB</p>
              </div>
            </div>
            <div v-if="formData.receiptFile" class="mt-2 text-sm text-green-600">
              ✓ File selected: {{ formData.receiptFile.name }}
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Notes</label>
            <textarea 
              v-model="formData.paymentNotes"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
              placeholder="Any additional notes about the payment..."
            ></textarea>
          </div>
        </div>

        <!-- Step 4: Review & Submit -->
        <div v-if="currentStep === 4" class="space-y-6">
          <h3 class="text-xl font-semibold text-gray-900">Review Enrollment Information</h3>
          
          <div class="bg-gray-50 rounded-lg p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <h4 class="font-semibold text-gray-900 mb-3">Child Information</h4>
                <div class="space-y-2 text-sm">
                  <p><span class="font-medium">Name:</span> {{ formData.childName }}</p>
                  <p><span class="font-medium">Date of Birth:</span> {{ formData.dateOfBirth }}</p>
                  <p><span class="font-medium">Gender:</span> {{ formData.gender }}</p>
                  <p><span class="font-medium">Age Group:</span> {{ formData.ageGroup }}</p>
                  <p><span class="font-medium">Position:</span> {{ formData.preferredPosition || 'Not specified' }}</p>
                  <p><span class="font-medium">Jersey Number:</span> {{ formData.jerseyNumber || 'Not specified' }}</p>
                </div>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900 mb-3">Emergency Contact</h4>
                <div class="space-y-2 text-sm">
                  <p><span class="font-medium">Name:</span> {{ formData.emergencyContactName }}</p>
                  <p><span class="font-medium">Phone:</span> {{ formData.emergencyContactPhone }}</p>
                  <p><span class="font-medium">Relationship:</span> {{ formData.emergencyContactRelation }}</p>
                </div>
              </div>
            </div>
            
            <div v-if="formData.medicalConditions" class="pt-4 border-t border-gray-200">
              <h4 class="font-semibold text-gray-900 mb-2">Medical Information</h4>
              <p class="text-sm text-gray-600">{{ formData.medicalConditions }}</p>
            </div>
            
            <div class="pt-4 border-t border-gray-200">
              <h4 class="font-semibold text-gray-900 mb-3">Payment Information</h4>
              <div class="space-y-2 text-sm">
                <p><span class="font-medium">Amount:</span> {{ formData.paymentAmount }} MVR</p>
                <p><span class="font-medium">Method:</span> {{ formData.paymentMethod }}</p>
                <p v-if="formData.transactionReference"><span class="font-medium">Reference:</span> {{ formData.transactionReference }}</p>
                <p><span class="font-medium">Date:</span> {{ formData.paymentDate }}</p>
                <p v-if="formData.paymentNotes"><span class="font-medium">Notes:</span> {{ formData.paymentNotes }}</p>
                <p v-if="formData.receiptFile"><span class="font-medium">Receipt:</span> {{ formData.receiptFile.name }}</p>
              </div>
            </div>
          </div>

          <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Important Notice</h3>
                <div class="mt-2 text-sm text-yellow-700">
                  <p>By submitting this enrollment form, you agree to the academy's terms and conditions. Your child's enrollment will be reviewed by our coaching staff, and you will be notified of the decision within 3-5 business days.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
          <button 
            v-if="currentStep > 1"
            @click="previousStep"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
          >
            Previous
          </button>
          <div v-else></div>
          
          <button 
            v-if="currentStep < 4"
            @click="nextStep"
            :disabled="!canProceed"
            class="px-6 py-2 bg-newradiant-blue text-white rounded-md hover:bg-newradiant-dark-blue disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            Next
          </button>
          <button 
            v-else
            @click="submitEnrollment"
            :disabled="isSubmitting"
            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <span v-if="isSubmitting">Submitting...</span>
            <span v-else>Submit Enrollment</span>
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import AdminLayout from '@/components/AdminLayout.vue'
import api from '@/services/api'

const router = useRouter()

const currentStep = ref(1)
const isSubmitting = ref(false)

const formData = ref({
  childName: '',
  dateOfBirth: '',
  gender: '',
  ageGroup: '',
  preferredPosition: '',
  jerseyNumber: '',
  experience: '',
  medicalConditions: '',
  emergencyContactName: '',
  emergencyContactPhone: '',
  emergencyContactRelation: '',
  paymentAmount: '',
  paymentMethod: '',
  transactionReference: '',
  paymentDate: '',
  paymentNotes: '',
  receiptFile: null
})

const canProceed = computed(() => {
  if (currentStep.value === 1) {
    return formData.value.childName && 
           formData.value.dateOfBirth && 
           formData.value.gender && 
           formData.value.ageGroup
  }
  if (currentStep.value === 2) {
    return formData.value.emergencyContactName && 
           formData.value.emergencyContactPhone && 
           formData.value.emergencyContactRelation
  }
  if (currentStep.value === 3) {
    return formData.value.paymentAmount && 
           formData.value.paymentMethod && 
           formData.value.paymentDate && 
           formData.value.receiptFile
  }
  return true
})

const nextStep = () => {
  if (canProceed.value && currentStep.value < 4) {
    currentStep.value++
  }
}

const handleReceiptUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    // Validate file size (2MB max)
    if (file.size > 2 * 1024 * 1024) {
      alert('File size must be less than 2MB')
      return
    }
    
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf']
    if (!allowedTypes.includes(file.type)) {
      alert('Please upload a valid image (JPG, PNG) or PDF file')
      return
    }
    
    formData.value.receiptFile = file
  }
}

const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}

const submitEnrollment = async () => {
  isSubmitting.value = true
  
  try {
    // Create FormData for file upload
    const formDataToSend = new FormData()
    
    // Add student data
    formDataToSend.append('name', formData.value.childName)
    formDataToSend.append('date_of_birth', formData.value.dateOfBirth)
    formDataToSend.append('gender', formData.value.gender)
    formDataToSend.append('age_group', formData.value.ageGroup)
    formDataToSend.append('position', formData.value.preferredPosition)
    formDataToSend.append('jersey_number', formData.value.jerseyNumber)
    formDataToSend.append('experience', formData.value.experience)
    formDataToSend.append('medical_notes', formData.value.medicalConditions)
    formDataToSend.append('emergency_contact_name', formData.value.emergencyContactName)
    formDataToSend.append('emergency_contact_phone', formData.value.emergencyContactPhone)
    formDataToSend.append('emergency_contact_relation', formData.value.emergencyContactRelation)
    
    // Add payment data
    formDataToSend.append('payment_amount', formData.value.paymentAmount)
    formDataToSend.append('payment_method', formData.value.paymentMethod)
    formDataToSend.append('transaction_reference', formData.value.transactionReference || '')
    formDataToSend.append('payment_date', formData.value.paymentDate)
    formDataToSend.append('payment_notes', formData.value.paymentNotes || '')
    
    // Add receipt file
    if (formData.value.receiptFile) {
      formDataToSend.append('receipt', formData.value.receiptFile)
    }
    
    const response = await api.post('/students/enroll', formDataToSend, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    
    alert('Child enrolled successfully! You will be notified once the enrollment and payment are reviewed.')
    router.push('/academy/my-children')
  } catch (error) {
    console.error('Enrollment failed:', error)
    alert('Failed to enroll child. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}
</script>
