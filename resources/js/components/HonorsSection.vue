<template>
  <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Club Honors</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Celebrating over four decades of excellence in Maldivian football
        </p>
      </div>

      <!-- Trophies Grid -->
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
        <div 
          v-for="honor in honors" 
          :key="honor.id"
          class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
        >
          <div class="text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
              <span class="text-3xl">{{ honor.icon }}</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ honor.title }}</h3>
            <p class="text-gray-600 mb-4">{{ honor.count }} {{ honor.count === 1 ? 'Time' : 'Times' }}</p>
            <div class="text-sm text-gray-500">
              <div v-for="year in honor.years" :key="year" class="inline-block mr-2 mb-1">
                <span class="px-2 py-1 bg-gray-100 rounded-full">{{ year }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Club History -->
      <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div>
            <h3 class="text-3xl font-bold text-gray-900 mb-6">Our Legacy</h3>
            <div class="space-y-6">
              <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-newradiant-blue rounded-full flex items-center justify-center">
                  <span class="text-white font-bold text-lg">1979</span>
                </div>
                <div class="ml-4">
                  <h4 class="text-xl font-semibold text-gray-900 mb-2">Founded</h4>
                  <p class="text-gray-600">New Radiant Sports Club was established in Malé, Maldives, with a vision to develop football talent and promote the sport across the nation.</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h4 class="text-xl font-semibold text-gray-900 mb-2">Rasmee Dhandu Stadium</h4>
                  <p class="text-gray-600">Our home ground, a modern facility that has hosted countless memorable matches and continues to be a symbol of our commitment to excellence.</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h4 class="text-xl font-semibold text-gray-900 mb-2">Youth Development</h4>
                  <p class="text-gray-600">Pioneering youth development programs that have produced numerous national team players and continue to shape the future of Maldivian football.</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="relative">
            <div class="bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue rounded-2xl p-8 text-white">
              <div class="text-center">
                <div class="w-32 h-32 mx-auto mb-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                  <span class="text-6xl font-bold">NR</span>
                </div>
                <h4 class="text-2xl font-bold mb-4">New Radiant SC</h4>
                <p class="text-lg mb-6 text-blue-100">Pride of Maldivian Football</p>
                <div class="grid grid-cols-2 gap-4 text-center">
                  <div>
                    <div class="text-3xl font-bold">45+</div>
                    <div class="text-sm text-blue-100">Years of Excellence</div>
                  </div>
                  <div>
                    <div class="text-3xl font-bold">100+</div>
                    <div class="text-sm text-blue-100">Trophies Won</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const honors = ref([
  {
    id: 1,
    title: 'Dhivehi Premier League',
    count: 8,
    icon: '🏆',
    years: ['2023', '2021', '2019', '2017', '2015', '2012', '2010', '2008']
  },
  {
    id: 2,
    title: 'FA Cup',
    count: 6,
    icon: '🥇',
    years: ['2022', '2020', '2018', '2016', '2014', '2011']
  },
  {
    id: 3,
    title: 'Youth Championship',
    count: 12,
    icon: '⚽',
    years: ['2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015', '2014', '2013']
  },
  {
    id: 4,
    title: 'Presidential Cup',
    count: 4,
    icon: '🏅',
    years: ['2023', '2021', '2019', '2017']
  }
])
</script>
