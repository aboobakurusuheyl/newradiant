<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Orders Management</h1>
          <p class="text-gray-600">Manage customer orders and fulfillment</p>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-newradiant-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Orders</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.total_orders || 0 }}</p>
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
              <p class="text-sm font-medium text-gray-500">Pending Orders</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.pending_orders || 0 }}</p>
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
              <p class="text-sm font-medium text-gray-500">Delivered Orders</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.delivered_orders || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Revenue</p>
              <p class="text-2xl font-semibold text-gray-900">${{ (stats.total_revenue || 0).toFixed(2) }}</p>
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
                placeholder="Search orders..."
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
              v-model="selectedStatus"
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            >
              <option value="">All Status</option>
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="shipped">Shipped</option>
              <option value="delivered">Delivered</option>
              <option value="cancelled">Cancelled</option>
            </select>
            
            <select 
              v-model="selectedPaymentStatus"
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            >
              <option value="">All Payment Status</option>
              <option value="pending">Pending</option>
              <option value="paid">Paid</option>
              <option value="failed">Failed</option>
              <option value="refunded">Refunded</option>
            </select>
            
            <input 
              v-model="dateFrom"
              type="date" 
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            />
            
            <input 
              v-model="dateTo"
              type="date" 
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
            />
          </div>
        </div>
      </div>

      <!-- Orders Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ order.order_number }}</div>
                  <div class="text-sm text-gray-500">#{{ order.id }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ order.customer_name }}</div>
                  <div class="text-sm text-gray-500">{{ order.customer_email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ order.order_items?.length || 0 }} items
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  ${{ order.total }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(order.status)" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ order.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getPaymentStatusBadgeClass(order.payment_status)" class="px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ order.payment_status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(order.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button 
                      @click="viewOrder(order)"
                      class="text-newradiant-blue hover:text-newradiant-dark-blue"
                    >
                      View
                    </button>
                    <button 
                      @click="updateOrderStatus(order)"
                      class="text-green-600 hover:text-green-900"
                    >
                      Update
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Order Details Modal -->
      <div v-if="showOrderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-medium text-gray-900">Order Details</h3>
              <button 
                @click="showOrderModal = false"
                class="text-gray-400 hover:text-gray-600"
              >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            
            <div v-if="selectedOrder" class="space-y-6">
              <!-- Order Info -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h4 class="font-semibold text-gray-900 mb-2">Order Information</h4>
                  <div class="space-y-1 text-sm">
                    <p><span class="font-medium">Order Number:</span> {{ selectedOrder.order_number }}</p>
                    <p><span class="font-medium">Order Date:</span> {{ formatDate(selectedOrder.created_at) }}</p>
                    <p><span class="font-medium">Status:</span> 
                      <span :class="getStatusBadgeClass(selectedOrder.status)" class="px-2 py-1 rounded-full text-xs font-medium">
                        {{ selectedOrder.status }}
                      </span>
                    </p>
                    <p><span class="font-medium">Payment Status:</span> 
                      <span :class="getPaymentStatusBadgeClass(selectedOrder.payment_status)" class="px-2 py-1 rounded-full text-xs font-medium">
                        {{ selectedOrder.payment_status }}
                      </span>
                    </p>
                  </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h4 class="font-semibold text-gray-900 mb-2">Customer Information</h4>
                  <div class="space-y-1 text-sm">
                    <p><span class="font-medium">Name:</span> {{ selectedOrder.customer_name }}</p>
                    <p><span class="font-medium">Email:</span> {{ selectedOrder.customer_email }}</p>
                    <p v-if="selectedOrder.customer_phone"><span class="font-medium">Phone:</span> {{ selectedOrder.customer_phone }}</p>
                  </div>
                </div>
              </div>

              <!-- Order Items -->
              <div>
                <h4 class="font-semibold text-gray-900 mb-2">Order Items</h4>
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="item in selectedOrder.order_items" :key="item.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">{{ item.product_name }}</div>
                          <div class="text-sm text-gray-500">{{ item.product_description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                          {{ item.size || 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                          {{ item.quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                          ${{ item.price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                          ${{ item.total }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Order Totals -->
              <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-2">Order Totals</h4>
                <div class="space-y-1 text-sm">
                  <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>${{ selectedOrder.subtotal }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span>Tax:</span>
                    <span>${{ selectedOrder.tax }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span>Shipping:</span>
                    <span>${{ selectedOrder.shipping }}</span>
                  </div>
                  <div class="flex justify-between font-semibold text-lg">
                    <span>Total:</span>
                    <span>${{ selectedOrder.total }}</span>
                  </div>
                </div>
              </div>

              <!-- Shipping Address -->
              <div>
                <h4 class="font-semibold text-gray-900 mb-2">Shipping Address</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ selectedOrder.shipping_address }}</pre>
                </div>
              </div>

              <!-- Order Notes -->
              <div v-if="selectedOrder.notes">
                <h4 class="font-semibold text-gray-900 mb-2">Order Notes</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <p class="text-sm text-gray-700">{{ selectedOrder.notes }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Status Update Modal -->
      <div v-if="showStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Order Status</h3>
            
            <form @submit.prevent="submitStatusUpdate">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <input 
                  :value="selectedOrder?.order_number"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50"
                  readonly
                />
              </div>
              
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select 
                  v-model="statusForm.status"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  required
                >
                  <option value="pending">Pending</option>
                  <option value="processing">Processing</option>
                  <option value="shipped">Shipped</option>
                  <option value="delivered">Delivered</option>
                  <option value="cancelled">Cancelled</option>
                </select>
              </div>
              
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                <select 
                  v-model="statusForm.payment_status"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  required
                >
                  <option value="pending">Pending</option>
                  <option value="paid">Paid</option>
                  <option value="failed">Failed</option>
                  <option value="refunded">Refunded</option>
                </select>
              </div>
              
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea 
                  v-model="statusForm.notes"
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-newradiant-blue focus:border-transparent outline-none"
                  placeholder="Add any notes about this order..."
                ></textarea>
              </div>
              
              <div class="flex justify-end space-x-3">
                <button 
                  type="button"
                  @click="showStatusModal = false"
                  class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                >
                  Cancel
                </button>
                <button 
                  type="submit"
                  :disabled="isSubmitting"
                  class="px-4 py-2 bg-newradiant-blue text-white rounded-md hover:bg-newradiant-dark-blue disabled:opacity-50"
                >
                  {{ isSubmitting ? 'Updating...' : 'Update Status' }}
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
const orders = ref([])
const stats = ref({})
const isLoading = ref(true)
const isSubmitting = ref(false)

// Modal states
const showOrderModal = ref(false)
const showStatusModal = ref(false)

// Form data
const statusForm = ref({
  status: '',
  payment_status: '',
  notes: ''
})

const selectedOrder = ref(null)

// Filters
const searchQuery = ref('')
const selectedStatus = ref('')
const selectedPaymentStatus = ref('')
const dateFrom = ref('')
const dateTo = ref('')

// Computed properties
const filteredOrders = computed(() => {
  let filtered = orders.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(order => 
      order.order_number.toLowerCase().includes(query) ||
      order.customer_name.toLowerCase().includes(query) ||
      order.customer_email.toLowerCase().includes(query)
    )
  }

  if (selectedStatus.value) {
    filtered = filtered.filter(order => order.status === selectedStatus.value)
  }

  if (selectedPaymentStatus.value) {
    filtered = filtered.filter(order => order.payment_status === selectedPaymentStatus.value)
  }

  if (dateFrom.value) {
    filtered = filtered.filter(order => new Date(order.created_at) >= new Date(dateFrom.value))
  }

  if (dateTo.value) {
    filtered = filtered.filter(order => new Date(order.created_at) <= new Date(dateTo.value))
  }

  return filtered
})

// Methods
const loadOrders = async () => {
  try {
    const response = await api.get('/orders')
    orders.value = response.data.data || response.data
  } catch (error) {
    console.error('Failed to load orders:', error)
  }
}

const loadStats = async () => {
  try {
    const response = await api.get('/orders/statistics')
    stats.value = response.data
  } catch (error) {
    console.error('Failed to load stats:', error)
  }
}

const viewOrder = async (order) => {
  try {
    const response = await api.get(`/orders/${order.id}`)
    selectedOrder.value = response.data
    showOrderModal.value = true
  } catch (error) {
    console.error('Failed to load order details:', error)
  }
}

const updateOrderStatus = (order) => {
  selectedOrder.value = order
  statusForm.value = {
    status: order.status,
    payment_status: order.payment_status,
    notes: order.notes || ''
  }
  showStatusModal.value = true
}

const submitStatusUpdate = async () => {
  isSubmitting.value = true
  
  try {
    await api.put(`/orders/${selectedOrder.value.id}`, statusForm.value)
    await loadOrders()
    await loadStats()
    showStatusModal.value = false
  } catch (error) {
    console.error('Failed to update order status:', error)
    alert('Failed to update order status. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const getStatusBadgeClass = (status) => {
  const classes = {
    'pending': 'bg-yellow-100 text-yellow-800',
    'processing': 'bg-blue-100 text-blue-800',
    'shipped': 'bg-purple-100 text-purple-800',
    'delivered': 'bg-green-100 text-green-800',
    'cancelled': 'bg-red-100 text-red-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getPaymentStatusBadgeClass = (status) => {
  const classes = {
    'pending': 'bg-yellow-100 text-yellow-800',
    'paid': 'bg-green-100 text-green-800',
    'failed': 'bg-red-100 text-red-800',
    'refunded': 'bg-gray-100 text-gray-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const formatDate = (date) => {
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
    loadOrders(),
    loadStats()
  ])
  isLoading.value = false
})
</script>
