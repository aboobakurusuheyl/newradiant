<template>
  <TransitionRoot as="template" :show="isOpen">
    <Dialog as="div" class="relative z-50" @close="closeModal">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
              <form @submit.prevent="handleSubmit">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                  <div class="sm:flex sm:items-start">
                    <div class="w-full">
                      <DialogTitle as="h3" class="text-lg font-semibold leading-6 text-gray-900 mb-6">
                        {{ isEditing ? 'Edit Player' : 'Add New Player' }}
                      </DialogTitle>
                      
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                          <input
                            v-model="form.first_name"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Last Name -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                          <input
                            v-model="form.last_name"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Nickname -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Nickname</label>
                          <input
                            v-model="form.nickname"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Jersey Number -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Jersey Number *</label>
                          <input
                            v-model.number="form.jersey_number"
                            type="number"
                            min="1"
                            max="99"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Position -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Position *</label>
                          <select
                            v-model="form.position"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          >
                            <option value="">Select Position</option>
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Defender">Defender</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Forward">Forward</option>
                          </select>
                        </div>

                        <!-- Position Detail -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Position Detail</label>
                          <input
                            v-model="form.position_detail"
                            type="text"
                            placeholder="e.g., Left Back, Center Forward"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Date of Birth -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                          <input
                            v-model="form.date_of_birth"
                            type="date"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Nationality -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Nationality *</label>
                          <input
                            v-model="form.nationality"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Height -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                          <input
                            v-model.number="form.height"
                            type="number"
                            min="100"
                            max="250"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Weight -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                          <input
                            v-model.number="form.weight"
                            type="number"
                            min="30"
                            max="150"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Preferred Foot -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Foot</label>
                          <select
                            v-model="form.preferred_foot"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          >
                            <option value="">Select Foot</option>
                            <option value="Left">Left</option>
                            <option value="Right">Right</option>
                            <option value="Both">Both</option>
                          </select>
                        </div>

                        <!-- Photo Upload -->
                        <div class="md:col-span-2">
                          <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                          <input
                            @change="handlePhotoChange"
                            type="file"
                            accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                          <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 2MB</p>
                        </div>

                        <!-- Biography -->
                        <div class="md:col-span-2">
                          <label class="block text-sm font-medium text-gray-700 mb-1">Biography</label>
                          <textarea
                            v-model="form.biography"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          ></textarea>
                        </div>

                        <!-- Contract Details -->
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Contract Start</label>
                          <input
                            v-model="form.contract_start"
                            type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Contract End</label>
                          <input
                            v-model="form.contract_end"
                            type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          />
                        </div>

                        <!-- Status Checkboxes -->
                        <div class="md:col-span-2 space-y-2">
                          <div class="flex items-center">
                            <input
                              v-model="form.is_active"
                              type="checkbox"
                              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            />
                            <label class="ml-2 text-sm text-gray-700">Active Player</label>
                          </div>
                          <div class="flex items-center">
                            <input
                              v-model="form.is_captain"
                              type="checkbox"
                              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            />
                            <label class="ml-2 text-sm text-gray-700">Team Captain</label>
                          </div>
                          <div class="flex items-center">
                            <input
                              v-model="form.is_vice_captain"
                              type="checkbox"
                              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            />
                            <label class="ml-2 text-sm text-gray-700">Vice Captain</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                  <button
                    type="submit"
                    class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto"
                  >
                    {{ isEditing ? 'Update Player' : 'Create Player' }}
                  </button>
                  <button
                    type="button"
                    @click="closeModal"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                  >
                    Cancel
                  </button>
                </div>
              </form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  player: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'save'])

const isEditing = computed(() => !!props.player)

const form = ref({
  first_name: '',
  last_name: '',
  nickname: '',
  jersey_number: '',
  position: '',
  position_detail: '',
  date_of_birth: '',
  nationality: '',
  height: '',
  weight: '',
  preferred_foot: '',
  photo: null,
  biography: '',
  contract_start: '',
  contract_end: '',
  is_active: true,
  is_captain: false,
  is_vice_captain: false,
  sort_order: 0
})

const handlePhotoChange = (event) => {
  form.value.photo = event.target.files[0]
}

const handleSubmit = () => {
  const formData = new FormData()
  
  Object.keys(form.value).forEach(key => {
    if (form.value[key] !== null && form.value[key] !== '') {
      if (key === 'photo' && form.value[key] instanceof File) {
        formData.append(key, form.value[key])
      } else if (key !== 'photo') {
        formData.append(key, form.value[key])
      }
    }
  })

  emit('save', formData)
}

const closeModal = () => {
  emit('close')
}

// Reset form when modal opens/closes
watch(() => props.isOpen, (isOpen) => {
  if (isOpen) {
    if (props.player) {
      // Edit mode - populate form
      Object.keys(form.value).forEach(key => {
        if (props.player[key] !== undefined) {
          form.value[key] = props.player[key]
        }
      })
    } else {
      // Create mode - reset form
      Object.keys(form.value).forEach(key => {
        if (key === 'is_active') {
          form.value[key] = true
        } else if (key === 'is_captain' || key === 'is_vice_captain') {
          form.value[key] = false
        } else {
          form.value[key] = ''
        }
      })
    }
  }
})
</script>
