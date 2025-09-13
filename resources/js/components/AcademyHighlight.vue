<template>
  <section class="py-20 bg-gradient-to-br from-newradiant-blue via-newradiant-light-blue to-newradiant-dark-blue text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-bold mb-6">New Radiant Academy</h2>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
          Developing the next generation of football stars through professional coaching and comprehensive training programs
        </p>
      </div>

      <!-- Academy Programs -->
      <div class="grid md:grid-cols-3 gap-10 mb-20">
        <div 
          v-for="program in programs" 
          :key="program.id"
          class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 hover:bg-opacity-20 transition-all duration-300 transform hover:-translate-y-2"
        >
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
              <span class="text-2xl">{{ program.icon }}</span>
            </div>
            <h3 class="text-2xl font-bold mb-4">{{ program.title }}</h3>
            <p class="text-blue-100 mb-6">{{ program.description }}</p>
            <ul class="text-left space-y-2">
              <li v-for="feature in program.features" :key="feature" class="flex items-center">
                <svg class="w-5 h-5 mr-3 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm">{{ feature }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Age Groups -->
      <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 mb-20">
        <h3 class="text-3xl font-bold text-center mb-12">Age Groups</h3>
        <div class="grid md:grid-cols-4 gap-8">
          <div 
            v-for="ageGroup in ageGroups" 
            :key="ageGroup.id"
            class="text-center bg-white bg-opacity-5 rounded-xl p-6 hover:bg-opacity-10 transition-all duration-300"
          >
            <div class="w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
              <span class="text-xl font-bold">{{ ageGroup.age }}</span>
            </div>
            <h4 class="text-lg font-semibold mb-2">{{ ageGroup.title }}</h4>
            <p class="text-sm text-blue-100">{{ ageGroup.description }}</p>
          </div>
        </div>
      </div>

      <!-- Coaching Staff -->
      <div class="grid lg:grid-cols-2 gap-16 items-center mb-20">
        <div>
          <h3 class="text-3xl font-bold mb-6">Professional Coaching Staff</h3>
          <p class="text-lg text-blue-100 mb-8">
            Our academy is led by experienced coaches with international qualifications and a proven track record in youth development.
          </p>
          <div class="space-y-4">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-semibold">Head Coach: Sobah Mohamed</h4>
                <p class="text-blue-100">UEFA Licensed Coach with 15+ years experience</p>
              </div>
            </div>
            <div class="flex items-center">
              <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-semibold">Fitness & Conditioning</h4>
                <p class="text-blue-100">Specialized training for physical development</p>
              </div>
            </div>
            <div class="flex items-center">
              <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-semibold">Technical Skills</h4>
                <p class="text-blue-100">Ball control, passing, shooting, and tactical awareness</p>
              </div>
            </div>
          </div>
        </div>
        <div class="relative">
          <div class="bg-white bg-opacity-10 rounded-2xl p-8 backdrop-blur-sm">
            <div class="text-center">
              <div class="w-32 h-32 mx-auto mb-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-6xl">⚽</span>
              </div>
              <h4 class="text-2xl font-bold mb-4">Join Our Academy</h4>
              <p class="text-blue-100 mb-6">Ready to start your football journey?</p>
              <div class="space-y-3">
                <RouterLink 
                  to="/academy/registration" 
                  class="block w-full bg-white text-newradiant-blue px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors"
                >
                  Register Now
                </RouterLink>
                <RouterLink 
                  to="/academy" 
                  class="block w-full border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-newradiant-blue transition-colors"
                >
                  Learn More
                </RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Academy Features -->
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div 
          v-for="feature in academyFeatures" 
          :key="feature.id"
          class="text-center bg-white bg-opacity-5 rounded-xl p-6 hover:bg-opacity-10 transition-all duration-300"
        >
          <div class="w-12 h-12 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
            <span class="text-xl">{{ feature.icon }}</span>
          </div>
          <h4 class="text-lg font-semibold mb-2">{{ feature.title }}</h4>
          <p class="text-sm text-blue-100">{{ feature.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'

const programs = ref([
  {
    id: 1,
    title: 'Foundation Program',
    icon: '🌱',
    description: 'Basic skills development for young players',
    features: [
      'Ball control fundamentals',
      'Basic passing and receiving',
      'Coordination exercises',
      'Fun-based learning approach'
    ]
  },
  {
    id: 2,
    title: 'Development Program',
    icon: '⚽',
    description: 'Advanced technical and tactical training',
    features: [
      'Position-specific training',
      'Tactical awareness',
      'Physical conditioning',
      'Match preparation'
    ]
  },
  {
    id: 3,
    title: 'Elite Program',
    icon: '🏆',
    description: 'High-performance training for serious players',
    features: [
      'Professional-level coaching',
      'Competition preparation',
      'Mental training',
      'Career pathway guidance'
    ]
  }
])

const ageGroups = ref([
  {
    id: 1,
    age: 'U-8',
    title: 'Mini Academy',
    description: 'Ages 6-8 years'
  },
  {
    id: 2,
    age: 'U-12',
    title: 'Junior Academy',
    description: 'Ages 9-12 years'
  },
  {
    id: 3,
    age: 'U-15',
    title: 'Youth Academy',
    description: 'Ages 13-15 years'
  },
  {
    id: 4,
    age: 'U-18',
    title: 'Senior Academy',
    description: 'Ages 16-18 years'
  }
])

const academyFeatures = ref([
  {
    id: 1,
    icon: '📊',
    title: 'Progress Tracking',
    description: 'Regular assessments and progress reports'
  },
  {
    id: 2,
    icon: '🏟️',
    title: 'Modern Facilities',
    description: 'State-of-the-art training grounds'
  },
  {
    id: 3,
    icon: '👨‍🏫',
    title: 'Expert Coaches',
    description: 'Licensed and experienced coaching staff'
  },
  {
    id: 4,
    icon: '🎯',
    title: 'Individual Attention',
    description: 'Personalized training programs'
  }
])
</script>
