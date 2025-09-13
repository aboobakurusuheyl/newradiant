<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <div class="mx-auto h-12 w-12 bg-newradiant-blue rounded-full flex items-center justify-center">
          <span class="text-white text-xl font-bold">NR</span>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Create your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Or
          <RouterLink to="/login" class="font-medium text-newradiant-blue hover:text-newradiant-dark-blue">
            sign in to your existing account
          </RouterLink>
        </p>
      </div>
      
      <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
        <div class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input
              id="name"
              name="name"
              type="text"
              required
              v-model="form.name"
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue sm:text-sm"
              placeholder="Enter your full name"
            />
          </div>
          
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input
              id="email"
              name="email"
              type="email"
              required
              v-model="form.email"
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue sm:text-sm"
              placeholder="Enter your email"
            />
          </div>
          
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              id="password"
              name="password"
              type="password"
              required
              v-model="form.password"
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue sm:text-sm"
              placeholder="Enter your password"
            />
          </div>
          
          <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select
              id="role"
              name="role"
              required
              v-model="form.role"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue sm:text-sm"
            >
              <option value="">Select your role</option>
              <option value="student">Student</option>
              <option value="parent">Parent</option>
            </select>
          </div>
        </div>

        <div v-if="error" class="text-red-600 text-sm text-center">
          {{ error }}
        </div>

        <div>
          <button
            type="submit"
            :disabled="isLoading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-newradiant-blue hover:bg-newradiant-dark-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-newradiant-blue disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="isLoading" class="absolute left-0 inset-y-0 flex items-center pl-3">
              <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
            </span>
            {{ isLoading ? 'Creating account...' : 'Create account' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  name: '',
  email: '',
  password: '',
  role: ''
})

const error = ref('')
const isLoading = ref(false)

const handleRegister = async () => {
  error.value = ''
  isLoading.value = true

  const result = await authStore.register(form.value)
  
  if (result.success) {
    router.push('/academy')
  } else {
    error.value = result.error
  }
  
  isLoading.value = false
}
</script>
