<template>
  <section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Fan Portal & Store</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Connect with fellow fans, get exclusive merchandise, and be part of the New Radiant family
        </p>
      </div>

      <!-- Fan Portal Features -->
      <div class="grid lg:grid-cols-2 gap-16 mb-20">
        <!-- Fan Portal -->
        <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
          <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue rounded-full flex items-center justify-center">
              <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-4">Fan Portal</h3>
            <p class="text-lg text-gray-600 mb-8">Join our community of passionate supporters and get exclusive access to club content and events.</p>
          </div>
          
          <div class="space-y-6">
            <div class="flex items-start">
              <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Exclusive Content</h4>
                <p class="text-gray-600">Behind-the-scenes videos, player interviews, and match highlights</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Fan Events</h4>
                <p class="text-gray-600">Meet & greets, stadium tours, and special fan gatherings</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Priority Access</h4>
                <p class="text-gray-600">Early ticket sales, exclusive merchandise, and special offers</p>
              </div>
            </div>
          </div>
          
          <div class="mt-8 text-center">
            <RouterLink 
              to="/fan-portal" 
              class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white rounded-lg font-semibold text-lg hover:from-newradiant-dark-blue hover:to-newradiant-blue transition-all duration-200 shadow-lg"
            >
              Join Fan Portal
              <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </RouterLink>
          </div>
        </div>

        <!-- Store Preview -->
        <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
          <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
              <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-4">Official Store</h3>
            <p class="text-lg text-gray-600 mb-8">Show your support with authentic New Radiant merchandise and gear.</p>
          </div>
          
          <!-- Featured Products -->
          <div class="grid grid-cols-2 gap-6 mb-8">
            <div 
              v-for="product in featuredProducts" 
              :key="product.id"
              class="group relative bg-gray-50 rounded-xl p-4 hover:shadow-lg transition-all duration-300"
            >
              <div class="aspect-square bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg mb-3 flex items-center justify-center">
                <span class="text-4xl">{{ product.icon }}</span>
              </div>
              <h4 class="font-semibold text-gray-900 mb-1">{{ product.name }}</h4>
              <p class="text-sm text-gray-600 mb-2">{{ product.description }}</p>
              <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-newradiant-blue">{{ product.price }}</span>
                <button class="opacity-0 group-hover:opacity-100 bg-newradiant-blue text-white px-3 py-1 rounded text-xs font-semibold transition-opacity duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
          
          <div class="text-center">
            <RouterLink 
              to="/store" 
              class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-semibold text-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg"
            >
              Visit Store
              <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </RouterLink>
          </div>
        </div>
      </div>

      <!-- Membership Benefits -->
      <div class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue rounded-2xl p-8 lg:p-12 text-white">
        <div class="text-center mb-12">
          <h3 class="text-3xl font-bold mb-4">Membership Benefits</h3>
          <p class="text-xl text-blue-100">Join our supporters club and enjoy exclusive privileges</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-10">
          <div 
            v-for="benefit in membershipBenefits" 
            :key="benefit.id"
            class="text-center"
          >
            <div class="w-16 h-16 mx-auto mb-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
              <span class="text-2xl">{{ benefit.icon }}</span>
            </div>
            <h4 class="text-xl font-semibold mb-4">{{ benefit.title }}</h4>
            <p class="text-blue-100">{{ benefit.description }}</p>
          </div>
        </div>
        
        <div class="text-center mt-12">
          <RouterLink 
            to="/fan-portal/membership" 
            class="inline-flex items-center px-8 py-4 bg-white text-newradiant-blue rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg"
          >
            Become a Member
            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </RouterLink>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'

const featuredProducts = ref([
  {
    id: 1,
    name: 'Home Jersey',
    description: '2024/25 Season',
    price: '$45',
    icon: '👕'
  },
  {
    id: 2,
    name: 'Away Jersey',
    description: '2024/25 Season',
    price: '$45',
    icon: '👕'
  },
  {
    id: 3,
    name: 'Training Kit',
    description: 'Professional Grade',
    price: '$35',
    icon: '👕'
  },
  {
    id: 4,
    name: 'Club Scarf',
    description: 'Official Merchandise',
    price: '$15',
    icon: '🧣'
  }
])

const membershipBenefits = ref([
  {
    id: 1,
    icon: '🎫',
    title: 'Priority Tickets',
    description: 'Get first access to match tickets and special events'
  },
  {
    id: 2,
    icon: '🎁',
    title: 'Exclusive Merchandise',
    description: 'Access to limited edition items and member-only products'
  },
  {
    id: 3,
    icon: '🏟️',
    title: 'Stadium Tours',
    description: 'Free guided tours of Rasmee Dhandu Stadium'
  }
])
</script>
