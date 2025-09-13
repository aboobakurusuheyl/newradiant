<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">News Management</h1>
          <p class="text-gray-600">Manage news articles and announcements</p>
        </div>
        <button 
          @click="showAddModal = true"
          class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors"
        >
          Add New Article
        </button>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-newradiant-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Articles</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.total_news || 0 }}</p>
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
              <p class="text-sm font-medium text-gray-500">Published</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.published_news || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Featured</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.featured_news || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Categories</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.news_categories?.length || 0 }}</p>
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
                placeholder="Search articles..."
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
              v-model="selectedCategory"
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            >
              <option value="all">All Categories</option>
              <option v-for="category in categories" :key="category" :value="category">
                {{ category }}
              </option>
            </select>
            
            <select 
              v-model="selectedStatus"
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            >
              <option value="all">All Status</option>
              <option value="published">Published</option>
              <option value="draft">Draft</option>
              <option value="featured">Featured</option>
            </select>
          </div>
        </div>
      </div>

      <!-- News Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="article in filteredNews" :key="article.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                      <img 
                        :src="article.featured_image || '/placeholder-news.jpg'" 
                        :alt="article.title"
                        class="h-12 w-12 rounded-lg object-cover"
                      />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ article.title }}</div>
                      <div class="text-sm text-gray-500 line-clamp-1">{{ article.excerpt || article.content?.substring(0, 100) + '...' }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ article.category }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ article.author?.name || 'Unknown' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex flex-wrap gap-1">
                    <span v-if="article.is_published" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      Published
                    </span>
                    <span v-else class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      Draft
                    </span>
                    <span v-if="article.is_featured" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                      Featured
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(article.published_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button 
                      @click="editArticle(article)"
                      class="text-newradiant-blue hover:text-newradiant-dark-blue"
                    >
                      Edit
                    </button>
                    <button 
                      @click="deleteArticle(article)"
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

      <!-- Add/Edit Article Modal -->
      <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              {{ showAddModal ? 'Add New Article' : 'Edit Article' }}
            </h3>
            
            <form @submit.prevent="submitArticle">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                  <input 
                    v-model="articleForm.title"
                    type="text" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
                
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                  <textarea 
                    v-model="articleForm.excerpt"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    placeholder="Brief description of the article..."
                  ></textarea>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                  <select 
                    v-model="articleForm.category"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  >
                    <option value="">Select Category</option>
                    <option value="general">General</option>
                    <option value="academy">Academy</option>
                    <option value="matches">Matches</option>
                    <option value="announcements">Announcements</option>
                    <option value="events">Events</option>
                  </select>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                  <select 
                    v-model="articleForm.type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  >
                    <option value="news">News</option>
                    <option value="announcement">Announcement</option>
                    <option value="event">Event</option>
                  </select>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                  <input 
                    @change="handleImageUpload"
                    type="file" 
                    accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Tags (comma separated)</label>
                  <input 
                    v-model="tagsInput"
                    type="text" 
                    placeholder="football, academy, training"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Published Date</label>
                  <input 
                    v-model="articleForm.published_at"
                    type="datetime-local"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Expires Date</label>
                  <input 
                    v-model="articleForm.expires_at"
                    type="datetime-local"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                  <textarea 
                    v-model="articleForm.content"
                    rows="10"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    placeholder="Write your article content here..."
                    required
                  ></textarea>
                </div>
                
                <div class="md:col-span-2">
                  <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                      <input 
                        v-model="articleForm.is_published"
                        type="checkbox" 
                        class="rounded border-gray-300 text-newradiant-blue focus:ring-newradiant-blue"
                      />
                      <span class="ml-2 text-sm text-gray-700">Published</span>
                    </label>
                    
                    <label class="flex items-center">
                      <input 
                        v-model="articleForm.is_featured"
                        type="checkbox" 
                        class="rounded border-gray-300 text-newradiant-blue focus:ring-newradiant-blue"
                      />
                      <span class="ml-2 text-sm text-gray-700">Featured</span>
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
                  {{ isSubmitting ? 'Saving...' : (showAddModal ? 'Add Article' : 'Update Article') }}
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
import { ref, onMounted, computed, watch } from 'vue'
import AdminLayout from '@/components/AdminLayout.vue'
import api from '@/services/api'

// Reactive data
const news = ref([])
const categories = ref([])
const stats = ref({})
const isLoading = ref(true)
const isSubmitting = ref(false)

// Modal states
const showAddModal = ref(false)
const showEditModal = ref(false)

// Form data
const articleForm = ref({
  title: '',
  content: '',
  excerpt: '',
  category: '',
  type: 'news',
  tags: [],
  is_published: false,
  is_featured: false,
  published_at: '',
  expires_at: '',
  featured_image: null
})

const selectedArticle = ref(null)
const tagsInput = ref('')

// Filters
const searchQuery = ref('')
const selectedCategory = ref('all')
const selectedStatus = ref('all')

// Computed properties
const filteredNews = computed(() => {
  let filtered = news.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(article => 
      article.title.toLowerCase().includes(query) ||
      article.content?.toLowerCase().includes(query) ||
      article.excerpt?.toLowerCase().includes(query)
    )
  }

  if (selectedCategory.value !== 'all') {
    filtered = filtered.filter(article => article.category === selectedCategory.value)
  }

  if (selectedStatus.value !== 'all') {
    if (selectedStatus.value === 'published') {
      filtered = filtered.filter(article => article.is_published)
    } else if (selectedStatus.value === 'draft') {
      filtered = filtered.filter(article => !article.is_published)
    } else if (selectedStatus.value === 'featured') {
      filtered = filtered.filter(article => article.is_featured)
    }
  }

  return filtered
})

// Methods
const loadNews = async () => {
  try {
    const response = await api.get('/content/news')
    news.value = response.data.data || response.data
  } catch (error) {
    console.error('Failed to load news:', error)
  }
}

const loadCategories = async () => {
  try {
    const response = await api.get('/content/stats')
    categories.value = response.data.news_categories || []
  } catch (error) {
    console.error('Failed to load categories:', error)
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

const handleImageUpload = (event) => {
  articleForm.value.featured_image = event.target.files[0]
}

const submitArticle = async () => {
  isSubmitting.value = true
  
  try {
    const formData = new FormData()
    
    // Add all form fields
    Object.keys(articleForm.value).forEach(key => {
      if (key === 'tags') {
        formData.append('tags', JSON.stringify(articleForm.value[key]))
      } else if (key === 'featured_image' && articleForm.value[key]) {
        formData.append('featured_image', articleForm.value[key])
      } else if (articleForm.value[key] !== null) {
        formData.append(key, articleForm.value[key])
      }
    })

    if (showAddModal.value) {
      await api.post('/content/news', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
    } else {
      await api.put(`/content/news/${selectedArticle.value.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
    }

    await loadNews()
    await loadStats()
    closeModal()
  } catch (error) {
    console.error('Failed to save article:', error)
    alert('Failed to save article. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const editArticle = (article) => {
  selectedArticle.value = article
  articleForm.value = { ...article }
  tagsInput.value = article.tags ? article.tags.join(', ') : ''
  showEditModal.value = true
}

const deleteArticle = async (article) => {
  if (!confirm(`Are you sure you want to delete "${article.title}"?`)) return
  
  try {
    await api.delete(`/content/news/${article.id}`)
    await loadNews()
    await loadStats()
  } catch (error) {
    console.error('Failed to delete article:', error)
    alert('Failed to delete article. Please try again.')
  }
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  selectedArticle.value = null
  articleForm.value = {
    title: '',
    content: '',
    excerpt: '',
    category: '',
    type: 'news',
    tags: [],
    is_published: false,
    is_featured: false,
    published_at: '',
    expires_at: '',
    featured_image: null
  }
  tagsInput.value = ''
}

const formatDate = (date) => {
  if (!date) return 'Not published'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Watch for tags input changes
watch(tagsInput, (newValue) => {
  articleForm.value.tags = newValue ? newValue.split(',').map(t => t.trim()).filter(t => t) : []
})

onMounted(async () => {
  await Promise.all([
    loadNews(),
    loadCategories(),
    loadStats()
  ])
  isLoading.value = false
})
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
