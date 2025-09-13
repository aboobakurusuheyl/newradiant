<template>
  <nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-20">
        <!-- Logo -->
        <div class="flex items-center">
          <RouterLink to="/" class="flex-shrink-0 flex items-center">
            <div class="w-8 h-8 mr-2">
              <Logo />
            </div>
            <div>
              <span class="text-lg font-bold text-gray-900">New Radiant SC</span>
              <p class="text-xs text-gray-600">Pride of Maldivian Football</p>
            </div>
          </RouterLink>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center space-x-8">
          <RouterLink 
            to="/" 
            class="text-gray-700 hover:text-newradiant-blue px-4 py-2 rounded-md text-sm font-semibold transition-colors"
            :class="{ 'text-newradiant-blue bg-blue-50': $route.path === '/' }"
          >
            Home
          </RouterLink>
          
          <RouterLink 
            to="/academy" 
            class="text-gray-700 hover:text-newradiant-blue px-4 py-2 rounded-md text-sm font-semibold transition-colors"
            :class="{ 'text-newradiant-blue bg-blue-50': $route.path === '/academy' }"
          >
            Academy
          </RouterLink>

          <RouterLink 
            to="/fixtures" 
            class="text-gray-700 hover:text-newradiant-blue px-4 py-2 rounded-md text-sm font-semibold transition-colors"
            :class="{ 'text-newradiant-blue bg-blue-50': $route.path === '/fixtures' }"
          >
            Fixtures & Results
          </RouterLink>
          
          <RouterLink 
            to="/news" 
            class="text-gray-700 hover:text-newradiant-blue px-4 py-2 rounded-md text-sm font-semibold transition-colors"
            :class="{ 'text-newradiant-blue bg-blue-50': $route.path === '/news' }"
          >
            News
          </RouterLink>
          
          <RouterLink 
            to="/store" 
            class="text-gray-700 hover:text-newradiant-blue px-4 py-2 rounded-md text-sm font-semibold transition-colors"
            :class="{ 'text-newradiant-blue bg-blue-50': $route.path === '/store' }"
          >
            Store
          </RouterLink>

          <!-- More Dropdown -->
          <div class="relative group">
            <button class="text-gray-700 hover:text-newradiant-blue px-4 py-2 rounded-md text-sm font-semibold transition-colors flex items-center">
              More
              <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
              <RouterLink to="/about" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">About Us</RouterLink>
              <RouterLink to="/team" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">First Team</RouterLink>
              <RouterLink to="/store" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Store</RouterLink>
              <RouterLink to="/fan-portal" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Fan Portal</RouterLink>
              <RouterLink to="/contact" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Contact</RouterLink>
            </div>
          </div>
        </div>

        <!-- Auth Section -->
        <div class="hidden lg:flex items-center space-x-4">
          <div v-if="authStore.isAuthenticated" class="flex items-center space-x-4">
            <RouterLink 
              to="/academy" 
              class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white px-6 py-2 rounded-lg text-sm font-semibold hover:from-newradiant-dark-blue hover:to-newradiant-blue transition-all duration-200 shadow-md"
            >
              Academy Portal
            </RouterLink>
            <div class="relative">
              <button 
                @click="toggleDropdown" 
                class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-newradiant-blue"
              >
                <span class="sr-only">Open user menu</span>
                <div class="w-10 h-10 bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue rounded-full flex items-center justify-center shadow-md">
                  <span class="text-white font-semibold text-sm">{{ authStore.user?.name?.charAt(0) }}</span>
                </div>
              </button>
              
              <div v-if="showDropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="px-4 py-3 border-b border-gray-100">
                  <div class="font-semibold text-gray-900">{{ authStore.user?.name }}</div>
                  <div class="text-sm text-gray-500">{{ authStore.user?.email }}</div>
                </div>
                <RouterLink to="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</RouterLink>
                <RouterLink to="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</RouterLink>
                <button 
                  @click="logout" 
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Sign out
                </button>
              </div>
            </div>
          </div>
          
          <div v-else class="flex items-center space-x-3">
            <RouterLink 
              to="/login" 
              class="text-gray-700 hover:text-newradiant-blue px-4 py-2 rounded-md text-sm font-semibold transition-colors"
            >
              Login
            </RouterLink>
            <RouterLink 
              to="/register" 
              class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white px-6 py-2 rounded-lg text-sm font-semibold hover:from-newradiant-dark-blue hover:to-newradiant-blue transition-all duration-200 shadow-md"
            >
              Register
            </RouterLink>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="lg:hidden flex items-center">
          <button 
            @click="toggleMobileMenu" 
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-newradiant-blue"
          >
            <span class="sr-only">Open main menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-if="showMobileMenu" class="lg:hidden bg-white border-t border-gray-200">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <RouterLink 
          to="/" 
          class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
        >
          Home
        </RouterLink>
        <RouterLink 
          to="/academy" 
          class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
        >
          Academy
        </RouterLink>
        <RouterLink 
          to="/fixtures" 
          class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
        >
          Fixtures & Results
        </RouterLink>
        <RouterLink 
          to="/news" 
          class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
        >
          News
        </RouterLink>
        <RouterLink 
          to="/store" 
          class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
        >
          Store
        </RouterLink>
        <RouterLink 
          to="/about" 
          class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
        >
          About Us
        </RouterLink>
        <RouterLink 
          to="/contact" 
          class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
        >
          Contact
        </RouterLink>
        
        <div v-if="authStore.isAuthenticated" class="pt-4 pb-3 border-t border-gray-200">
          <div class="flex items-center px-3">
            <div class="w-10 h-10 bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue rounded-full flex items-center justify-center">
              <span class="text-white font-semibold">{{ authStore.user?.name?.charAt(0) }}</span>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800">{{ authStore.user?.name }}</div>
              <div class="text-sm text-gray-500">{{ authStore.user?.email }}</div>
            </div>
          </div>
          <div class="mt-3 space-y-1">
            <RouterLink 
              to="/academy" 
              class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white block px-3 py-2 rounded-md text-base font-medium"
            >
              Academy Portal
            </RouterLink>
            <button 
              @click="logout" 
              class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
            >
              Sign out
            </button>
          </div>
        </div>
        
        <div v-else class="pt-4 pb-3 border-t border-gray-200">
          <RouterLink 
            to="/login" 
            class="text-gray-700 hover:text-newradiant-blue block px-3 py-2 rounded-md text-base font-medium"
          >
            Login
          </RouterLink>
          <RouterLink 
            to="/register" 
            class="bg-gradient-to-r from-newradiant-blue to-newradiant-light-blue text-white block px-3 py-2 rounded-md text-base font-medium mt-2"
          >
            Register
          </RouterLink>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'
import { RouterLink, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Logo from './logo.vue'

const authStore = useAuthStore()
const route = useRoute()
const showDropdown = ref(false)
const showMobileMenu = ref(false)

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
}

const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value
}

const logout = async () => {
  await authStore.logout()
  showDropdown.value = false
  showMobileMenu.value = false
}
</script>
