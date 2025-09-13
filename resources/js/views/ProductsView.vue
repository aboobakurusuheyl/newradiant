<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Products Management</h1>
          <p class="text-gray-600">Manage store products and inventory</p>
        </div>
        <button 
          @click="showAddModal = true"
          class="bg-newradiant-blue text-white px-4 py-2 rounded-lg hover:bg-newradiant-dark-blue transition-colors"
        >
          Add New Product
        </button>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-newradiant-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Products</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.total_products || 0 }}</p>
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
              <p class="text-sm font-medium text-gray-500">Active Products</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.active_products || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Low Stock</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.low_stock || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Out of Stock</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.out_of_stock || 0 }}</p>
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
                placeholder="Search products..."
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
              <option value="active">Active</option>
              <option value="sale">On Sale</option>
              <option value="new">New</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Products Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                      <img 
                        :src="product.image || '/placeholder-product.jpg'" 
                        :alt="product.name"
                        class="h-12 w-12 rounded-lg object-cover"
                      />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                      <div class="text-sm text-gray-500">{{ product.sku }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ product.category }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <div class="flex items-center space-x-2">
                    <span v-if="product.is_sale && product.sale_price" class="text-lg font-bold text-green-600">
                      ${{ product.sale_price }}
                    </span>
                    <span :class="[
                      'text-lg font-bold',
                      product.is_sale && product.sale_price ? 'text-gray-400 line-through' : 'text-gray-900'
                    ]">
                      ${{ product.price }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-900">{{ product.stock }}</span>
                    <button 
                      @click="updateStock(product)"
                      class="text-newradiant-blue hover:text-newradiant-dark-blue text-xs"
                    >
                      Edit
                    </button>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex flex-wrap gap-1">
                    <span v-if="product.is_active" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      Active
                    </span>
                    <span v-if="product.is_new" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      New
                    </span>
                    <span v-if="product.is_sale" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                      Sale
                    </span>
                    <span v-if="product.stock === 0" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      Out of Stock
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button 
                      @click="editProduct(product)"
                      class="text-newradiant-blue hover:text-newradiant-dark-blue"
                    >
                      Edit
                    </button>
                    <button 
                      @click="deleteProduct(product)"
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

      <!-- Add/Edit Product Modal -->
      <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              {{ showAddModal ? 'Add New Product' : 'Edit Product' }}
            </h3>
            
            <form @submit.prevent="submitProduct">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                  <input 
                    v-model="productForm.name"
                    type="text" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
                
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                  <textarea 
                    v-model="productForm.description"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  ></textarea>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                  <input 
                    v-model="productForm.price"
                    type="number" 
                    step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Sale Price</label>
                  <input 
                    v-model="productForm.sale_price"
                    type="number" 
                    step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                  <select 
                    v-model="productForm.category"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  >
                    <option value="">Select Category</option>
                    <option value="jerseys">Jerseys</option>
                    <option value="accessories">Accessories</option>
                    <option value="equipment">Equipment</option>
                    <option value="merchandise">Merchandise</option>
                  </select>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                  <input 
                    v-model="productForm.stock"
                    type="number" 
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    required
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                  <input 
                    v-model="productForm.sku"
                    type="text" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Sizes (comma separated)</label>
                  <input 
                    v-model="sizesInput"
                    type="text" 
                    placeholder="S, M, L, XL"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                  <input 
                    @change="handleImageUpload"
                    type="file" 
                    accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  />
                </div>
                
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                  <textarea 
                    v-model="productForm.features"
                    rows="2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                    placeholder="Product features and specifications..."
                  ></textarea>
                </div>
                
                <div class="md:col-span-2">
                  <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                      <input 
                        v-model="productForm.is_active"
                        type="checkbox" 
                        class="rounded border-gray-300 text-newradiant-blue focus:ring-newradiant-blue"
                      />
                      <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                    
                    <label class="flex items-center">
                      <input 
                        v-model="productForm.is_new"
                        type="checkbox" 
                        class="rounded border-gray-300 text-newradiant-blue focus:ring-newradiant-blue"
                      />
                      <span class="ml-2 text-sm text-gray-700">New</span>
                    </label>
                    
                    <label class="flex items-center">
                      <input 
                        v-model="productForm.is_sale"
                        type="checkbox" 
                        class="rounded border-gray-300 text-newradiant-blue focus:ring-newradiant-blue"
                      />
                      <span class="ml-2 text-sm text-gray-700">On Sale</span>
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
                  {{ isSubmitting ? 'Saving...' : (showAddModal ? 'Add Product' : 'Update Product') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Stock Update Modal -->
      <div v-if="showStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Stock</h3>
            
            <form @submit.prevent="submitStockUpdate">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                <input 
                  :value="selectedProduct?.name"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50"
                  readonly
                />
              </div>
              
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">New Stock Level</label>
                <input 
                  v-model="stockForm.stock"
                  type="number" 
                  min="0"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  required
                />
              </div>
              
              <div class="flex justify-end space-x-3">
                <button 
                  type="button"
                  @click="showStockModal = false"
                  class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                >
                  Cancel
                </button>
                <button 
                  type="submit"
                  :disabled="isSubmitting"
                  class="px-4 py-2 bg-newradiant-blue text-white rounded-md hover:bg-newradiant-dark-blue disabled:opacity-50"
                >
                  {{ isSubmitting ? 'Updating...' : 'Update Stock' }}
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
const products = ref([])
const categories = ref([])
const stats = ref({})
const isLoading = ref(true)
const isSubmitting = ref(false)

// Modal states
const showAddModal = ref(false)
const showEditModal = ref(false)
const showStockModal = ref(false)

// Form data
const productForm = ref({
  name: '',
  description: '',
  price: '',
  sale_price: '',
  category: '',
  stock: 0,
  sku: '',
  sizes: [],
  features: '',
  is_active: true,
  is_new: false,
  is_sale: false,
  image: null
})

const stockForm = ref({
  stock: 0
})

const selectedProduct = ref(null)
const sizesInput = ref('')

// Filters
const searchQuery = ref('')
const selectedCategory = ref('all')
const selectedStatus = ref('all')

// Computed properties
const filteredProducts = computed(() => {
  let filtered = products.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(product => 
      product.name.toLowerCase().includes(query) ||
      product.sku?.toLowerCase().includes(query)
    )
  }

  if (selectedCategory.value !== 'all') {
    filtered = filtered.filter(product => product.category === selectedCategory.value)
  }

  if (selectedStatus.value !== 'all') {
    if (selectedStatus.value === 'active') {
      filtered = filtered.filter(product => product.is_active)
    } else if (selectedStatus.value === 'sale') {
      filtered = filtered.filter(product => product.is_sale)
    } else if (selectedStatus.value === 'new') {
      filtered = filtered.filter(product => product.is_new)
    }
  }

  return filtered
})

// Methods
const loadProducts = async () => {
  try {
    const response = await api.get('/products')
    products.value = response.data.data || response.data
  } catch (error) {
    console.error('Failed to load products:', error)
  }
}

const loadCategories = async () => {
  try {
    const response = await api.get('/products/categories')
    categories.value = response.data
  } catch (error) {
    console.error('Failed to load categories:', error)
  }
}

const loadStats = async () => {
  try {
    // Calculate stats from products
    const totalProducts = products.value.length
    const activeProducts = products.value.filter(p => p.is_active).length
    const lowStock = products.value.filter(p => p.stock > 0 && p.stock < 10).length
    const outOfStock = products.value.filter(p => p.stock === 0).length

    stats.value = {
      total_products: totalProducts,
      active_products: activeProducts,
      low_stock: lowStock,
      out_of_stock: outOfStock
    }
  } catch (error) {
    console.error('Failed to load stats:', error)
  }
}

const handleImageUpload = (event) => {
  productForm.value.image = event.target.files[0]
}

const submitProduct = async () => {
  isSubmitting.value = true
  
  try {
    const formData = new FormData()
    
    // Add all form fields
    Object.keys(productForm.value).forEach(key => {
      if (key === 'sizes') {
        formData.append('sizes', JSON.stringify(productForm.value[key]))
      } else if (key === 'image' && productForm.value[key]) {
        formData.append('image', productForm.value[key])
      } else if (productForm.value[key] !== null) {
        formData.append(key, productForm.value[key])
      }
    })

    if (showAddModal.value) {
      await api.post('/products', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
    } else {
      await api.put(`/products/${selectedProduct.value.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
    }

    await loadProducts()
    await loadStats()
    closeModal()
  } catch (error) {
    console.error('Failed to save product:', error)
    alert('Failed to save product. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const editProduct = (product) => {
  selectedProduct.value = product
  productForm.value = { ...product }
  sizesInput.value = product.sizes ? product.sizes.join(', ') : ''
  showEditModal.value = true
}

const updateStock = (product) => {
  selectedProduct.value = product
  stockForm.value.stock = product.stock
  showStockModal.value = true
}

const submitStockUpdate = async () => {
  isSubmitting.value = true
  
  try {
    await api.post(`/products/${selectedProduct.value.id}/stock`, stockForm.value)
    await loadProducts()
    await loadStats()
    showStockModal.value = false
  } catch (error) {
    console.error('Failed to update stock:', error)
    alert('Failed to update stock. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const deleteProduct = async (product) => {
  if (!confirm(`Are you sure you want to delete "${product.name}"?`)) return
  
  try {
    await api.delete(`/products/${product.id}`)
    await loadProducts()
    await loadStats()
  } catch (error) {
    console.error('Failed to delete product:', error)
    alert('Failed to delete product. Please try again.')
  }
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  showStockModal.value = false
  selectedProduct.value = null
  productForm.value = {
    name: '',
    description: '',
    price: '',
    sale_price: '',
    category: '',
    stock: 0,
    sku: '',
    sizes: [],
    features: '',
    is_active: true,
    is_new: false,
    is_sale: false,
    image: null
  }
  sizesInput.value = ''
}

// Watch for sizes input changes
watch(sizesInput, (newValue) => {
  productForm.value.sizes = newValue ? newValue.split(',').map(s => s.trim()).filter(s => s) : []
})

onMounted(async () => {
  await Promise.all([
    loadProducts(),
    loadCategories()
  ])
  await loadStats()
  isLoading.value = false
})
</script>
