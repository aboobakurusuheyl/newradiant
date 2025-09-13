<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Show navbar and footer only for public pages -->
    <template v-if="!isAcademyPage">
      <Navbar />
      <main>
        <RouterView />
      </main>
      <Footer />
    </template>
    
    <!-- For academy pages, just show the content (AdminLayout handles its own navigation) -->
    <template v-else>
      <RouterView />
    </template>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { RouterView, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'

const authStore = useAuthStore()
const route = useRoute()

const isAcademyPage = computed(() => {
  return route.path.startsWith('/academy')
})

onMounted(() => {
  authStore.initializeAuth()
})
</script>
