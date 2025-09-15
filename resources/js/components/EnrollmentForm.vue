<template>
  <div class="max-w-4xl mx-auto px-6 py-12 bg-white rounded-lg shadow-lg">
    <!-- Header -->
    <div class="text-center mb-8">
      <div class="flex items-center justify-center mb-4">
        <Logo class="w-16 h-16 mr-4" />
        <div>
          <h1 class="text-3xl font-bold text-gray-900">New Radiant SC</h1>
          <p class="text-lg text-blue-600">Academy Registration Form</p>
        </div>
      </div>
      <p class="text-gray-600">Player of Tomorrow, Learn Today</p>
    </div>

    <!-- Success Message -->
    <div v-if="showSuccess" class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ successMessage }}
      </div>
    </div>

    <!-- Error Message -->
    <div v-if="showError" class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        {{ errorMessage }}
      </div>
    </div>

    <form @submit.prevent="submitForm" class="space-y-8">
      <!-- Student Information Section -->
      <div class="bg-gray-50 p-6 rounded-lg">
        <h2 class="text-xl font-bold text-red-600 mb-6">STUDENT</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">FIRST NAME *</label>
            <input
              v-model="form.first_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.first_name" class="text-red-500 text-sm mt-1">{{ errors.first_name[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">LAST NAME *</label>
            <input
              v-model="form.last_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.last_name" class="text-red-500 text-sm mt-1">{{ errors.last_name[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">DATE OF BIRTH *</label>
            <input
              v-model="form.date_of_birth"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.date_of_birth" class="text-red-500 text-sm mt-1">{{ errors.date_of_birth[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">GENDER *</label>
            <div class="flex space-x-4 mt-2">
              <label class="flex items-center">
                <input
                  v-model="form.gender"
                  type="radio"
                  value="M"
                  required
                  class="mr-2"
                />
                Male
              </label>
              <label class="flex items-center">
                <input
                  v-model="form.gender"
                  type="radio"
                  value="F"
                  required
                  class="mr-2"
                />
                Female
              </label>
            </div>
            <div v-if="errors.gender" class="text-red-500 text-sm mt-1">{{ errors.gender[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">ID NUMBER</label>
            <input
              v-model="form.id_number"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.id_number" class="text-red-500 text-sm mt-1">{{ errors.id_number[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">TELEPHONE NO *</label>
            <input
              v-model="form.telephone_no"
              type="tel"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.telephone_no" class="text-red-500 text-sm mt-1">{{ errors.telephone_no[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NATIONALITY *</label>
            <input
              v-model="form.nationality"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.nationality" class="text-red-500 text-sm mt-1">{{ errors.nationality[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">SCHOOL ATTENDED *</label>
            <input
              v-model="form.school_attended"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.school_attended" class="text-red-500 text-sm mt-1">{{ errors.school_attended[0] }}</div>
          </div>
        </div>

        <div class="mt-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">HOME ADDRESS *</label>
          <textarea
            v-model="form.home_address"
            required
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          ></textarea>
          <div v-if="errors.home_address" class="text-red-500 text-sm mt-1">{{ errors.home_address[0] }}</div>
        </div>
      </div>

      <!-- Parent/Guardian Information Section -->
      <div class="bg-gray-50 p-6 rounded-lg">
        <h2 class="text-xl font-bold text-red-600 mb-6">PARENTS/GUARDIAN</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NAME *</label>
            <input
              v-model="form.parent_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.parent_name" class="text-red-500 text-sm mt-1">{{ errors.parent_name[0] }}</div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">TELEPHONE NO/M *</label>
            <input
              v-model="form.parent_telephone"
              type="tel"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <div v-if="errors.parent_telephone" class="text-red-500 text-sm mt-1">{{ errors.parent_telephone[0] }}</div>
          </div>
        </div>
      </div>

      <!-- Photograph Section -->
      <div class="bg-gray-50 p-6 rounded-lg">
        <h2 class="text-xl font-bold text-gray-700 mb-6">PHOTOGRAPH</h2>
        
        <div class="flex items-center space-x-6">
          <div class="w-32 h-40 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
            <div v-if="!form.photograph" class="text-center text-gray-500">
              <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <p class="text-sm">Upload Photo</p>
            </div>
            <img v-else :src="photoPreview" alt="Preview" class="w-full h-full object-cover rounded-lg" />
          </div>
          
          <div>
            <input
              ref="photoInput"
              type="file"
              accept="image/*"
              @change="handlePhotoUpload"
              class="hidden"
            />
            <button
              type="button"
              @click="$refs.photoInput.click()"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              {{ form.photograph ? 'Change Photo' : 'Select Photo' }}
            </button>
            <p class="text-sm text-gray-500 mt-2">Please attach one recent photograph and copy of ID/Passport</p>
            <div v-if="errors.photograph" class="text-red-500 text-sm mt-1">{{ errors.photograph[0] }}</div>
          </div>
        </div>
      </div>

      <!-- How did you hear about us Section -->
      <div class="bg-gray-50 p-6 rounded-lg">
        <h2 class="text-xl font-bold text-gray-700 mb-6">Where did you hear about us?</h2>
        
        <div class="space-y-3">
          <label class="flex items-center">
            <input
              v-model="form.heard_about"
              type="radio"
              value="newspaper"
              required
              class="mr-3"
            />
            Newspaper
          </label>
          <label class="flex items-center">
            <input
              v-model="form.heard_about"
              type="radio"
              value="family_friends"
              required
              class="mr-3"
            />
            Family or Friends
          </label>
          <label class="flex items-center">
            <input
              v-model="form.heard_about"
              type="radio"
              value="social_media"
              required
              class="mr-3"
            />
            Social Media (FB/Inst)
          </label>
          <label class="flex items-center">
            <input
              v-model="form.heard_about"
              type="radio"
              value="other"
              required
              class="mr-3"
            />
            Other (Please specify)
          </label>
        </div>
        
        <div v-if="form.heard_about === 'other'" class="mt-4">
          <input
            v-model="form.heard_about_other"
            type="text"
            placeholder="Please specify"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <div v-if="errors.heard_about_other" class="text-red-500 text-sm mt-1">{{ errors.heard_about_other[0] }}</div>
        </div>
        <div v-if="errors.heard_about" class="text-red-500 text-sm mt-1">{{ errors.heard_about[0] }}</div>
      </div>

      <!-- Terms & Conditions -->
      <div class="bg-gray-50 p-6 rounded-lg">
        <h2 class="text-xl font-bold text-gray-700 mb-6">Terms & Conditions</h2>
        
        <div class="space-y-4 text-sm text-gray-700">
          <p>• Please attach: One recent photograph and copy of ID/Passport.</p>
          <p>• Fee should be paid in advance for the month before 10th of every month.</p>
          <p>• Fees for every month is 250 MVR applies to all students. 5% sibling discount applies from second child.</p>
          <p>• No makeup sessions will be offered for missed classes and strictly no refunds without submission of medical certificate.</p>
          <p>• Parent/Guardian ensure that the participant is physically fit and able to participate in the sporting activities and accordingly you accept all risks resulting from participation in the course.</p>
          <p class="mt-4">By signing above the parent/legal guardian confirms that the player has no known physical/mental condition preventing him participating in the above sports or related activities including physical fitness sessions.</p>
        </div>
      </div>

      <!-- Contact Information -->
      <div class="text-center text-red-600">
        <p class="font-medium">Note: For more information Please Contact:</p>
        <p class="text-lg font-bold">7890990, 7770340</p>
      </div>

      <!-- Submit Button -->
      <div class="text-center">
        <button
          type="submit"
          :disabled="isSubmitting"
          class="px-8 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ isSubmitting ? 'Submitting...' : 'Submit Application' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import Logo from './logo.vue'

const form = reactive({
  first_name: '',
  last_name: '',
  date_of_birth: '',
  gender: '',
  id_number: '',
  home_address: '',
  telephone_no: '',
  nationality: '',
  school_attended: '',
  parent_name: '',
  parent_telephone: '',
  photograph: null,
  heard_about: '',
  heard_about_other: ''
})

const errors = ref({})
const isSubmitting = ref(false)
const showSuccess = ref(false)
const showError = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const photoPreview = ref('')

const handlePhotoUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.photograph = file
    
    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
      photoPreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const submitForm = async () => {
  isSubmitting.value = true
  errors.value = {}
  showSuccess.value = false
  showError.value = false

  try {
    const formData = new FormData()
    
    // Add all form fields to FormData
    Object.keys(form).forEach(key => {
      if (form[key] !== null && form[key] !== '') {
        formData.append(key, form[key])
      }
    })

    const response = await fetch('/api/enrollments', {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })

    const data = await response.json()

    if (data.success) {
      showSuccess.value = true
      successMessage.value = data.message
      
      // Reset form
      Object.keys(form).forEach(key => {
        if (key === 'photograph') {
          form[key] = null
        } else {
          form[key] = ''
        }
      })
      photoPreview.value = ''
      
      // Scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' })
    } else {
      if (data.errors) {
        errors.value = data.errors
      } else {
        showError.value = true
        errorMessage.value = data.message || 'An error occurred while submitting your application.'
      }
    }
  } catch (error) {
    console.error('Error submitting form:', error)
    showError.value = true
    errorMessage.value = 'An error occurred while submitting your application. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}
</script>
