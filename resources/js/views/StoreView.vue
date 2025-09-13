<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-newradiant-blue to-blue-600 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-bold mb-4">New Radiant Store</h1>
          <p class="text-xl md:text-2xl mb-8">Official merchandise and fan gear</p>
          <p class="text-lg opacity-90">Show your support for the Pride of Maldivian Football</p>
        </div>
      </div>
    </div>

    <!-- Store Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Categories -->
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Shop by Category</h2>
        <div class="flex flex-wrap gap-4">
          <button 
            v-for="category in categories" 
            :key="category.id"
            @click="selectedCategory = category.id"
            :class="[
              'px-6 py-3 rounded-full font-medium transition-colors',
              selectedCategory === category.id 
                ? 'bg-newradiant-blue text-white' 
                : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300'
            ]"
          >
            {{ category.name }}
          </button>
        </div>
      </div>

      <!-- Search and Filter -->
      <div class="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
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
            v-model="sortBy"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
          >
            <option value="name">Sort by Name</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="newest">Newest First</option>
          </select>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-newradiant-blue"></div>
        <p class="mt-4 text-gray-600 text-lg">Loading products...</p>
      </div>

      <!-- Products Grid -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div 
          v-for="product in filteredProducts" 
          :key="product.id"
          class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group flex flex-col h-full"
        >
          <!-- Product Image -->
          <div class="relative aspect-square overflow-hidden">
            <img 
              :src="product.image_url || product.image" 
              :alt="product.name"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              @error="handleImageError"
            />
            <div v-if="product.is_new" class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">
              NEW
            </div>
            <div v-if="product.is_sale" class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
              SALE
            </div>
          </div>

          <!-- Product Info -->
          <div class="p-4 flex flex-col flex-grow">
            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ product.name }}</h3>
            <p class="text-sm text-gray-600 mb-3 flex-grow">{{ product.description }}</p>
            
            <!-- Price -->
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center space-x-2">
                <span v-if="product.is_sale" class="text-lg font-bold text-green-600">
                  ${{ product.sale_price }}
                </span>
                <span :class="[
                  'text-lg font-bold',
                  product.is_sale ? 'text-gray-400 line-through' : 'text-gray-900'
                ]">
                  ${{ product.price }}
                </span>
              </div>
              <div class="text-sm text-gray-500">
                {{ product.category }}
              </div>
            </div>

            <!-- Size Selection (for clothing) -->
            <div v-if="product.sizes && product.sizes.length > 0" class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
              <div class="flex flex-wrap gap-2">
                <button 
                  v-for="size in product.sizes" 
                  :key="size"
                  @click="selectedSizes[product.id] = size"
                  :class="[
                    'px-3 py-1 text-sm border rounded-md transition-colors',
                    selectedSizes[product.id] === size 
                      ? 'bg-newradiant-blue text-white border-newradiant-blue' 
                      : 'border-gray-300 text-gray-700 hover:bg-gray-50'
                  ]"
                >
                  {{ size }}
                </button>
              </div>
            </div>

            <!-- Add to Cart Button - Always at bottom -->
            <button 
              @click="addToCart(product)"
              class="w-full bg-newradiant-blue text-white py-2 px-4 rounded-lg hover:bg-newradiant-dark-blue transition-colors font-medium mt-auto"
            >
              Add to Cart
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="filteredProducts.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
        <p class="text-gray-500">Try adjusting your search or filter criteria</p>
      </div>
    </div>

    <!-- Shopping Cart Sidebar -->
    <div 
      v-if="showCart" 
      class="fixed inset-0 bg-black bg-opacity-50 z-50"
      @click="showCart = false"
    >
      <div 
        class="fixed right-0 top-0 h-full w-96 bg-white shadow-xl transform transition-transform duration-300"
        @click.stop
      >
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
          <h2 class="text-xl font-semibold text-gray-900">Shopping Cart</h2>
          <button 
            @click="showCart = false"
            class="text-gray-400 hover:text-gray-600"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6">
          <div v-if="cartItems.length === 0" class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
            </svg>
            <p class="text-gray-500">Your cart is empty</p>
          </div>

          <div v-else class="space-y-4">
            <div 
              v-for="item in cartItems" 
              :key="item.id"
              class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg"
            >
              <img :src="item.image_url || item.image" :alt="item.name" class="w-16 h-16 object-cover rounded" @error="handleImageError" />
              <div class="flex-1">
                <h3 class="font-medium text-gray-900">{{ item.name }}</h3>
                <p class="text-sm text-gray-500">{{ item.size }}</p>
                <p class="text-sm font-medium text-gray-900">${{ item.price }}</p>
              </div>
              <div class="flex items-center space-x-2">
                <button 
                  @click="updateQuantity(item.id, item.quantity - 1)"
                  class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50"
                >
                  -
                </button>
                <span class="w-8 text-center">{{ item.quantity }}</span>
                <button 
                  @click="updateQuantity(item.id, item.quantity + 1)"
                  class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50"
                >
                  +
                </button>
                <button 
                  @click="removeFromCart(item.id)"
                  class="text-red-500 hover:text-red-700 ml-2"
                >
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-if="cartItems.length > 0" class="border-t border-gray-200 p-6">
          <div class="flex justify-between items-center mb-4">
            <span class="text-lg font-semibold text-gray-900">Total</span>
            <span class="text-lg font-bold text-gray-900">${{ cartTotal }}</span>
          </div>
          <button class="w-full bg-newradiant-blue text-white py-3 px-4 rounded-lg hover:bg-newradiant-dark-blue transition-colors font-medium">
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>

    <!-- Cart Button -->
    <button 
      @click="showCart = true"
      class="fixed bottom-6 right-6 bg-newradiant-blue text-white p-4 rounded-full shadow-lg hover:bg-newradiant-dark-blue transition-colors z-40"
    >
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
      </svg>
      <span v-if="cartItems.length > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center">
        {{ cartItems.length }}
      </span>
    </button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'

// Reactive data
const selectedCategory = ref('all')
const searchQuery = ref('')
const sortBy = ref('name')
const showCart = ref(false)
const selectedSizes = ref({})
const cartItems = ref([])
const products = ref([])
const loading = ref(true)

// Categories
const categories = ref([
  { id: 'all', name: 'All Products' },
  { id: 'jerseys', name: 'Jerseys' },
  { id: 'accessories', name: 'Accessories' },
  { id: 'equipment', name: 'Equipment' },
  { id: 'merchandise', name: 'Merchandise' }
])

// Methods
const fetchProducts = async () => {
  try {
    loading.value = true
    const response = await api.get('/products')
    products.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching products:', error)
  } finally {
    loading.value = false
  }
}

const handleImageError = (event) => {
  // Fallback to default product image
  event.target.src = '/img/player.png'
}

// Computed properties
const filteredProducts = computed(() => {
  let filtered = products.value

  // Filter by category
  if (selectedCategory.value !== 'all') {
    filtered = filtered.filter(product => product.category === selectedCategory.value)
  }

  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(product => 
      product.name.toLowerCase().includes(query) ||
      product.description.toLowerCase().includes(query)
    )
  }

  // Sort products
  filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'name':
        return a.name.localeCompare(b.name)
      case 'price-low':
        return (a.is_sale ? a.sale_price : a.price) - (b.is_sale ? b.sale_price : b.price)
      case 'price-high':
        return (b.is_sale ? b.sale_price : b.price) - (a.is_sale ? a.sale_price : a.price)
      case 'newest':
        return b.is_new - a.is_new
      default:
        return 0
    }
  })

  return filtered
})

const cartTotal = computed(() => {
  return cartItems.value.reduce((total, item) => {
    return total + (item.sale ? item.price : item.price) * item.quantity
  }, 0).toFixed(2)
})

// Methods
const addToCart = (product) => {
  const size = selectedSizes.value[product.id] || (product.sizes.length > 0 ? product.sizes[0] : null)
  
  const existingItem = cartItems.value.find(item => 
    item.id === product.id && item.size === size
  )

  if (existingItem) {
    existingItem.quantity += 1
  } else {
    cartItems.value.push({
      id: product.id,
      name: product.name,
      price: product.is_sale ? product.sale_price : product.price,
      sale: product.is_sale,
      image: product.image_url || product.image,
      image_url: product.image_url || product.image,
      size: size || 'One Size',
      quantity: 1
    })
  }

  // Show cart briefly
  showCart.value = true
  setTimeout(() => {
    showCart.value = false
  }, 2000)
}

const updateQuantity = (productId, newQuantity) => {
  if (newQuantity <= 0) {
    removeFromCart(productId)
    return
  }

  const item = cartItems.value.find(item => item.id === productId)
  if (item) {
    item.quantity = newQuantity
  }
}

const removeFromCart = (productId) => {
  const index = cartItems.value.findIndex(item => item.id === productId)
  if (index > -1) {
    cartItems.value.splice(index, 1)
  }
}

onMounted(() => {
  // Load cart from localStorage if available
  const savedCart = localStorage.getItem('newradiant-cart')
  if (savedCart) {
    cartItems.value = JSON.parse(savedCart)
  }
  
  // Fetch products from API
  fetchProducts()
})

// Save cart to localStorage whenever it changes
import { watch } from 'vue'
watch(cartItems, (newCart) => {
  localStorage.setItem('newradiant-cart', JSON.stringify(newCart))
}, { deep: true })
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
