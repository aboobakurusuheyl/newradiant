<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-900/80" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                  <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="size-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>

              <!-- Mobile Sidebar -->
              <div class="relative flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                  <div class="w-8 h-8 mr-3">
                    <Logo />
                  </div>
                  <div>
                    <h3 class="text-lg font-bold text-gray-900">New Radiant SC</h3>
                    <p class="text-xs text-gray-600">Academy Portal</p>
                  </div>
                </div>
                <nav class="flex flex-1 flex-col">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                      <ul role="list" class="-mx-2 space-y-1">
                        <li v-for="item in navigation" :key="item.name">
                          <RouterLink :to="item.href" :class="[item.current ? 'bg-gray-50 text-newradiant-blue' : 'text-gray-700 hover:bg-gray-50 hover:text-newradiant-blue', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                            <component :is="item.icon" :class="[item.current ? 'text-newradiant-blue' : 'text-gray-400 group-hover:text-newradiant-blue', 'size-6 shrink-0']" aria-hidden="true" />
                            {{ item.name }}
                          </RouterLink>
                        </li>
                      </ul>
                    </li>
                    <li v-if="userRole === 'admin' || userRole === 'coach'">
                      <div class="text-xs/6 font-semibold text-gray-400">Management</div>
                      <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li v-for="item in managementItems" :key="item.name">
                          <RouterLink :to="item.href" :class="[item.current ? 'bg-gray-50 text-newradiant-blue' : 'text-gray-700 hover:bg-gray-50 hover:text-newradiant-blue', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                            <component :is="item.icon" :class="[item.current ? 'text-newradiant-blue' : 'text-gray-400 group-hover:text-newradiant-blue', 'size-6 shrink-0']" aria-hidden="true" />
                            {{ item.name }}
                          </RouterLink>
                        </li>
                      </ul>
                    </li>
                    <li class="mt-auto">
                      <button @click="logout" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-red-600">
                        <ArrowRightOnRectangleIcon class="size-6 shrink-0 text-gray-400 group-hover:text-red-600" aria-hidden="true" />
                        Sign out
                      </button>
                    </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden bg-gray-900 lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
      <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
          <div class="w-8 h-8 mr-3">
            <Logo />
          </div>
          <div>
            <h3 class="text-lg font-bold text-gray-900">New Radiant SC</h3>
            <p class="text-xs text-gray-600">Academy Portal</p>
          </div>
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <li v-for="item in navigation" :key="item.name">
                  <RouterLink :to="item.href" :class="[item.current ? 'bg-gray-50 text-newradiant-blue' : 'text-gray-700 hover:bg-gray-50 hover:text-newradiant-blue', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                    <component :is="item.icon" :class="[item.current ? 'text-newradiant-blue' : 'text-gray-400 group-hover:text-newradiant-blue', 'size-6 shrink-0']" aria-hidden="true" />
                    {{ item.name }}
                  </RouterLink>
                </li>
              </ul>
            </li>
            <li v-if="userRole === 'admin' || userRole === 'coach'">
              <div class="text-xs/6 font-semibold text-gray-400">Management</div>
              <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li v-for="item in managementItems" :key="item.name">
                  <RouterLink :to="item.href" :class="[item.current ? 'bg-gray-50 text-newradiant-blue' : 'text-gray-700 hover:bg-gray-50 hover:text-newradiant-blue', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']">
                    <component :is="item.icon" :class="[item.current ? 'text-newradiant-blue' : 'text-gray-400 group-hover:text-newradiant-blue', 'size-6 shrink-0']" aria-hidden="true" />
                    {{ item.name }}
                  </RouterLink>
                </li>
              </ul>
            </li>
            <li class="mt-auto">
              <button @click="logout" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-red-600">
                <ArrowRightOnRectangleIcon class="size-6 shrink-0 text-gray-400 group-hover:text-red-600" aria-hidden="true" />
                Sign out
              </button>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="lg:pl-72">
      <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 hover:text-gray-900 lg:hidden" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3Icon class="size-6" aria-hidden="true" />
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true" />

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
          <form class="grid flex-1 grid-cols-1" @submit.prevent="handleSearch">
            <input 
              v-model="searchQuery"
              name="search" 
              aria-label="Search" 
              class="col-start-1 row-start-1 block size-full bg-white pl-8 pr-4 py-2 text-base text-gray-900 border-0 outline-none placeholder:text-gray-400 sm:text-sm/6" 
              style="border: none !important; box-shadow: none !important;"
              placeholder="Search students, schedules..." 
            />
            <MagnifyingGlassIcon class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400 ml-2" aria-hidden="true" />
          </form>
          <div class="flex items-center gap-x-4 lg:gap-x-6">
            <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
              <span class="sr-only">View notifications</span>
              <BellIcon class="size-6" aria-hidden="true" />
            </button>

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true" />

            <!-- Profile dropdown -->
            <Menu as="div" class="relative">
              <MenuButton class="relative flex items-center">
                <span class="absolute -inset-1.5" />
                <span class="sr-only">Open user menu</span>
                <div class="size-8 rounded-full bg-gradient-to-br from-newradiant-blue to-newradiant-light-blue flex items-center justify-center">
                  <span class="text-white font-semibold text-sm">{{ userInitials }}</span>
                </div>
                <span class="hidden lg:flex lg:items-center">
                  <span class="ml-4 text-sm/6 font-semibold text-gray-900" aria-hidden="true">{{ user?.name }}</span>
                  <ChevronDownIcon class="ml-2 size-5 text-gray-400" aria-hidden="true" />
                </span>
              </MenuButton>
              <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform scale-100" leave-to-class="transform opacity-0 scale-95">
                <MenuItems class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg outline outline-1 outline-gray-900/5">
                  <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                    <RouterLink :to="item.href" :class="[active ? 'bg-gray-50 outline-none' : '', 'block px-3 py-1 text-sm/6 text-gray-900']">{{ item.name }}</RouterLink>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
      </div>

      <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  Bars3Icon,
  BellIcon,
  CalendarIcon,
  ChartPieIcon,
  DocumentDuplicateIcon,
  FolderIcon,
  HomeIcon,
  UsersIcon,
  XMarkIcon,
  ArrowRightOnRectangleIcon,
  UserGroupIcon,
  AcademicCapIcon,
  CurrencyDollarIcon,
  StarIcon,
  NewspaperIcon,
  Cog6ToothIcon,
  ShoppingBagIcon,
  ShoppingCartIcon,
  PhotoIcon,
  TrophyIcon,
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
import Logo from './logo.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const sidebarOpen = ref(false)
const searchQuery = ref('')

const user = computed(() => authStore.user)
const userRole = computed(() => user.value?.role)
const userInitials = computed(() => {
  if (!user.value?.name) return 'U'
  return user.value.name.split(' ').map(n => n[0]).join('').toUpperCase()
})

const navigation = computed(() => {
  const baseNav = [
    { name: 'Dashboard', href: '/academy', icon: HomeIcon, current: route.path === '/academy' },
  ]

  if (userRole.value === 'admin' || userRole.value === 'coach') {
    baseNav.push(
      { name: 'Students', href: '/academy/students', icon: UsersIcon, current: route.path.startsWith('/academy/students') },
      { name: 'Schedules', href: '/academy/schedules', icon: CalendarIcon, current: route.path.startsWith('/academy/schedules') },
      { name: 'Payments', href: '/academy/payments', icon: CurrencyDollarIcon, current: route.path.startsWith('/academy/payments') },
      { name: 'Ratings', href: '/academy/ratings', icon: StarIcon, current: route.path.startsWith('/academy/ratings') },
      { name: 'News', href: '/academy/news', icon: NewspaperIcon, current: route.path.startsWith('/academy/news') }
    )
  } else if (userRole.value === 'parent' || userRole.value === 'student') {
    baseNav.push(
      { name: 'My Schedule', href: '/academy/schedule', icon: CalendarIcon, current: route.path.startsWith('/academy/schedule') },
      { name: 'My Progress', href: '/academy/progress', icon: ChartPieIcon, current: route.path.startsWith('/academy/progress') },
      { name: 'My Payments', href: '/academy/payments', icon: CurrencyDollarIcon, current: route.path.startsWith('/academy/payments') },
      { name: 'Documents', href: '/academy/documents', icon: DocumentDuplicateIcon, current: route.path.startsWith('/academy/documents') }
    )
    
    // Add parent-specific options
    if (userRole.value === 'parent') {
      baseNav.push(
        { name: 'My Children', href: '/academy/my-children', icon: UsersIcon, current: route.path.startsWith('/academy/my-children') },
        { name: 'Enroll Child', href: '/academy/enroll', icon: UserGroupIcon, current: route.path.startsWith('/academy/enroll') }
      )
    }
  }

  return baseNav
})

const managementItems = computed(() => {
  if (userRole.value !== 'admin' && userRole.value !== 'coach') return []
  
  const items = [
    { name: 'Manage Students', href: '/academy/students', icon: UserGroupIcon, current: route.path.startsWith('/academy/students') },
    { name: 'Training Programs', href: '/academy/programs', icon: AcademicCapIcon, current: route.path.startsWith('/academy/programs') },
  ]
  
  // Add store management for admin only
  if (userRole.value === 'admin') {
    items.push(
      { name: 'Enrollments', href: '/academy/enrollments', icon: UserGroupIcon, current: route.path.startsWith('/academy/enrollments') },
      { name: 'First Team', href: '/academy/first-team', icon: TrophyIcon, current: route.path.startsWith('/academy/first-team') },
      { name: 'Products', href: '/academy/products', icon: ShoppingBagIcon, current: route.path.startsWith('/academy/products') },
      { name: 'Orders', href: '/academy/orders', icon: ShoppingCartIcon, current: route.path.startsWith('/academy/orders') },
      { name: 'News Management', href: '/academy/news-management', icon: NewspaperIcon, current: route.path.startsWith('/academy/news-management') },
      { name: 'Hero Management', href: '/academy/hero-management', icon: PhotoIcon, current: route.path.startsWith('/academy/hero-management') }
    )
  }
  
  items.push(
    { name: 'Settings', href: '/academy/settings', icon: Cog6ToothIcon, current: route.path.startsWith('/academy/settings') }
  )
  
  return items
})

const userNavigation = [
  { name: 'Your profile', href: '/academy/profile' },
  { name: 'Settings', href: '/academy/settings' },
]

const handleSearch = () => {
  // Implement search functionality
  console.log('Searching for:', searchQuery.value)
}

const logout = async () => {
  await authStore.logout()
  router.push('/')
}
</script>
