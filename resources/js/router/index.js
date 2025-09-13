import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import HomeView from "@/views/HomeView.vue";

const router = createRouter({
    history: createWebHistory("/"),
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeView,
        },
        {
            path: "/about",
            name: "about",
            component: () => import("@/views/AboutView.vue"),
        },
        {
            path: "/player/:id",
            name: "player-details",
            component: () => import("@/views/PublicPlayerDetailsView.vue"),
        },
        {
            path: "/contact",
            name: "contact",
            component: () => import("@/views/ContactView.vue"),
        },
        {
            path: "/news",
            name: "news",
            component: () => import("@/views/NewsView.vue"),
        },
        {
            path: "/news/:id",
            name: "news-detail",
            component: () => import("@/views/NewsDetailView.vue"),
        },
        {
            path: "/fixtures",
            name: "fixtures",
            component: () => import("@/views/FixturesView.vue"),
        },
        {
            path: "/store",
            name: "store",
            component: () => import("@/views/StoreView.vue"),
        },
        {
            path: "/login",
            name: "login",
            component: () => import("@/views/LoginView.vue"),
        },
        {
            path: "/register",
            name: "register",
            component: () => import("@/views/RegisterView.vue"),
        },
        {
            path: "/academy",
            name: "academy",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/academy/students",
            name: "academy-students",
            component: () => import("@/views/StudentsView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin", "coach"] },
        },
        {
            path: "/academy/schedules",
            name: "academy-schedules",
            component: () => import("@/views/SchedulesView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin", "coach"] },
        },
        {
            path: "/academy/payments",
            name: "academy-payments",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/academy/ratings",
            name: "academy-ratings",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin", "coach"] },
        },
        {
            path: "/academy/news",
            name: "academy-news",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin", "coach"] },
        },
        {
            path: "/academy/schedule",
            name: "academy-schedule",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true, requiresRole: ["parent", "student"] },
        },
        {
            path: "/academy/progress",
            name: "academy-progress",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true, requiresRole: ["parent", "student"] },
        },
        {
            path: "/academy/documents",
            name: "academy-documents",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true, requiresRole: ["parent", "student"] },
        },
        {
            path: "/academy/profile",
            name: "academy-profile",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/academy/settings",
            name: "academy-settings",
            component: () => import("@/views/AcademyView.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/academy/enroll",
            name: "academy-enroll",
            component: () => import("@/views/EnrollChildView.vue"),
            meta: { requiresAuth: true, requiresRole: ["parent"] },
        },
        {
            path: "/academy/my-children",
            name: "academy-my-children",
            component: () => import("@/views/MyChildrenView.vue"),
            meta: { requiresAuth: true, requiresRole: ["parent"] },
        },
        {
            path: "/academy/products",
            name: "academy-products",
            component: () => import("@/views/ProductsView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin"] },
        },
        {
            path: "/academy/orders",
            name: "academy-orders",
            component: () => import("@/views/OrdersView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin"] },
        },
        {
            path: "/academy/news-management",
            name: "academy-news-management",
            component: () => import("@/views/NewsManagementView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin"] },
        },
        {
            path: "/academy/hero-management",
            name: "academy-hero-management",
            component: () => import("@/views/HeroSectionManagementView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin"] },
        },
        {
            path: "/academy/first-team",
            name: "academy-first-team",
            component: () => import("@/views/FirstTeamView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin"] },
        },
        {
            path: "/academy/first-team/player/:id",
            name: "academy-player-details",
            component: () => import("@/views/PlayerDetailsView.vue"),
            meta: { requiresAuth: true, requiresRole: ["admin"] },
        },
    ],
});

// Navigation guards
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next("/login");
    } else if (to.meta.requiresRole && authStore.isAuthenticated) {
        const userRole = authStore.user?.role;
        const allowedRoles = to.meta.requiresRole;

        if (!allowedRoles.includes(userRole)) {
            next("/academy"); // Redirect to academy dashboard if role not allowed
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
