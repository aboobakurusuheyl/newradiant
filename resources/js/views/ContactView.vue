<template>
  <div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Get in touch with New Radiant Sports Club for any inquiries or information.
        </p>
      </div>

      <div class="grid md:grid-cols-2 gap-12">
        <div>
          <h2 class="text-3xl font-bold text-gray-900 mb-6">Contact Information</h2>
          <div class="space-y-6">
            <div class="flex items-start">
              <div class="w-6 h-6 bg-newradiant-blue rounded-full flex items-center justify-center mr-4 mt-1">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Address</h3>
                <p class="text-gray-600">Rasmee Dhandu Stadium<br>Malé, Maldives</p>
              </div>
            </div>

            <div class="flex items-start">
              <div class="w-6 h-6 bg-newradiant-blue rounded-full flex items-center justify-center mr-4 mt-1">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                <p class="text-gray-600">+960 123-4567</p>
              </div>
            </div>

            <div class="flex items-start">
              <div class="w-6 h-6 bg-newradiant-blue rounded-full flex items-center justify-center mr-4 mt-1">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                <p class="text-gray-600">info@newradiant.mv</p>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-8">
          <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>
          <form class="space-y-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue">
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue">
            </div>
            <div>
              <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
              <input type="text" id="subject" name="subject" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue">
            </div>
            <div>
              <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
              <textarea id="message" name="message" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-newradiant-blue focus:border-newradiant-blue"></textarea>
            </div>
            <div>
              <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-newradiant-blue hover:bg-newradiant-dark-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-newradiant-blue">
                Send Message
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
