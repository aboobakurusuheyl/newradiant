<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Hero Section Management</h1>
          <p class="text-gray-600">Manage homepage hero sections and announcements</p>
        </div>
        <button 
          @click="showAddModal = true"
          class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors"
        >
          Add New Hero Section
        </button>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-newradiant-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Sections</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.total_hero_sections || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Active</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.active_hero_sections || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Hero Sections</p>
              <p class="text-2xl font-semibold text-gray-900">{{ getTypeCount('hero') }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Announcements</p>
              <p class="text-2xl font-semibold text-gray-900">{{ getTypeCount('announcement') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
          <div class="flex-1 max-w-md">
            <div class="relative">
              <input 
                v-model="searchQuery"
                type="text" 
                placeholder="Search hero sections..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
              />
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
          
          <div class="flex gap-4">
            <select 
              v-model="selectedType"
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            >
              <option value="all">All Types</option>
              <option value="hero">Hero</option>
              <option value="announcement">Announcement</option>
              <option value="promotion">Promotion</option>
            </select>
            
            <select 
              v-model="selectedStatus"
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            >
              <option value="all">All Status</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Hero Sections Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="section in filteredSections" :key="section.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                      <img 
                        :src="section.image || '/placeholder-hero.jpg'" 
                        :alt="section.title"
                        class="h-12 w-12 rounded-lg object-cover"
                      />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ section.title }}</div>
                      <div class="text-sm text-gray-500">{{ section.subtitle }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getTypeBadgeClass(section.type)" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ section.type }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="section.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ section.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ section.sort_order }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(section.published_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button 
                      @click="editSection(section)"
                      class="text-newradiant-blue hover:text-newradiant-dark-blue"
                    >
                      Edit
                    </button>
                    <button 
                      @click="deleteSection(section)"
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
      </div>

      <!-- Add/Edit Section Modal -->
      <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              {{ showAddModal ? 'Add New Hero Section' : 'Edit Hero Section' }}
            </h3>
            
            <form @submit.prevent="submitSection">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                  <input 
                    v-model="sectionForm.title"
                    type="text" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
                
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                  <input 
                    v-model="sectionForm.subtitle"
                    type="text" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                  <select 
                    v-model="sectionForm.type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  >
                    <option value="hero">Hero</option>
                    <option value="announcement">Announcement</option>
                    <option value="promotion">Promotion</option>
                  </select>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                  <input 
                    v-model="sectionForm.sort_order"
                    type="number" 
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                  <input 
                    v-model="sectionForm.button_text"
                    type="text" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    placeholder="e.g., Learn More, Join Now"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                  <input 
                    v-model="sectionForm.button_link"
                    type="url" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    placeholder="https://example.com"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Published Date</label>
                  <input 
                    v-model="sectionForm.published_at"
                    type="datetime-local"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Expires Date</label>
                  <input 
                    v-model="sectionForm.expires_at"
                    type="datetime-local"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                  <textarea 
                    v-model="sectionForm.description"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    placeholder="Detailed description of the hero section..."
                  ></textarea>
                </div>
                
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Hero Image</label>
                  <input 
                    @change="handleImageUpload"
                    type="file" 
                    accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div class="md:col-span-2">
                  <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                      <input 
                        v-model="sectionForm.is_active"
                        type="checkbox" 
                        class="rounded border-gray-300 text-newradiant-blue focus:ring-newradiant-blue"
                      />
                      <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                  </div>
                </div>
              </div>
              
              <div class="flex justify-end space-x-3 mt-6">
                <button 
                  type="button"
                  @click="closeModal"
                  class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                >
                  Cancel
                </button>
                <button 
                  type="submit"
                  :disabled="isSubmitting"
                  class="px-4 py-2 bg-newradiant-blue text-white rounded-md hover:bg-newradiant-dark-blue disabled:opacity-50"
                >
                  {{ isSubmitting ? 'Saving...' : (showAddModal ? 'Add Section' : 'Update Section') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import AdminLayout from '@/components/AdminLayout.vue'
import api from '@/services/api'

// Reactive data
const sections = ref([])
const stats = ref({})
const isLoading = ref(true)
const isSubmitting = ref(false)

// Modal states
const showAddModal = ref(false)
const showEditModal = ref(false)

// Form data
const sectionForm = ref({
  title: '',
  subtitle: '',
  description: '',
  type: 'hero',
  button_text: '',
  button_link: '',
  is_active: true,
  sort_order: 0,
  published_at: '',
  expires_at: '',
  image: null
})

const selectedSection = ref(null)

// Filters
const searchQuery = ref('')
const selectedType = ref('all')
const selectedStatus = ref('all')

// Computed properties
const filteredSections = computed(() => {
  let filtered = sections.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(section => 
      section.title.toLowerCase().includes(query) ||
      section.subtitle?.toLowerCase().includes(query) ||
      section.description?.toLowerCase().includes(query)
    )
  }

  if (selectedType.value !== 'all') {
    filtered = filtered.filter(section => section.type === selectedType.value)
  }

  if (selectedStatus.value !== 'all') {
    if (selectedStatus.value === 'active') {
      filtered = filtered.filter(section => section.is_active)
    } else if (selectedStatus.value === 'inactive') {
      filtered = filtered.filter(section => !section.is_active)
    }
  }

  return filtered
})

// Methods
const loadSections = async () => {
  try {
    const response = await api.get('/content/hero-sections')
    sections.value = response.data.data || response.data
  } catch (error) {
    console.error('Failed to load hero sections:', error)
  }
}

const loadStats = async () => {
  try {
    const response = await api.get('/content/stats')
    stats.value = response.data
  } catch (error) {
    console.error('Failed to load stats:', error)
  }
}

const getTypeCount = (type) => {
  return sections.value.filter(section => section.type === type).length
}

const getTypeBadgeClass = (type) => {
  const classes = {
    'hero': 'bg-blue-100 text-blue-800',
    'announcement': 'bg-yellow-100 text-yellow-800',
    'promotion': 'bg-green-100 text-green-800'
  }
  return classes[type] || 'bg-gray-100 text-gray-800'
}

const handleImageUpload = (event) => {
  sectionForm.value.image = event.target.files[0]
}

const submitSection = async () => {
  isSubmitting.value = true
  
  try {
    const formData = new FormData()
    
    // Add all form fields
    Object.keys(sectionForm.value).forEach(key => {
      if (key === 'image' && sectionForm.value[key]) {
        formData.append('image', sectionForm.value[key])
      } else if (sectionForm.value[key] !== null) {
        formData.append(key, sectionForm.value[key])
      }
    })

    if (showAddModal.value) {
      await api.post('/content/hero-sections', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
    } else {
      await api.put(`/content/hero-sections/${selectedSection.value.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
    }

    await loadSections()
    await loadStats()
    closeModal()
  } catch (error) {
    console.error('Failed to save hero section:', error)
    alert('Failed to save hero section. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const editSection = (section) => {
  selectedSection.value = section
  sectionForm.value = { ...section }
  showEditModal.value = true
}

const deleteSection = async (section) => {
  if (!confirm(`Are you sure you want to delete "${section.title}"?`)) return
  
  try {
    await api.delete(`/content/hero-sections/${section.id}`)
    await loadSections()
    await loadStats()
  } catch (error) {
    console.error('Failed to delete hero section:', error)
    alert('Failed to delete hero section. Please try again.')
  }
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  selectedSection.value = null
  sectionForm.value = {
    title: '',
    subtitle: '',
    description: '',
    type: 'hero',
    button_text: '',
    button_link: '',
    is_active: true,
    sort_order: 0,
    published_at: '',
    expires_at: '',
    image: null
  }
}

const formatDate = (date) => {
  if (!date) return 'Not set'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

onMounted(async () => {
  await Promise.all([
    loadSections(),
    loadStats()
  ])
  isLoading.value = false
})
</script>
