import { defineStore } from "pinia";
import { ref, computed } from "vue";
import api from "@/services/api";

export const useAuthStore = defineStore("auth", () => {
    const user = ref(null);
    const token = ref(localStorage.getItem("auth_token"));
    const isLoading = ref(false);

    const isAuthenticated = computed(() => !!token.value && !!user.value);
    const isAdmin = computed(() => user.value?.role === "admin");
    const isMember = computed(() => user.value?.role === "member");
    const isCoach = computed(() => user.value?.role === "coach");
    const isStudent = computed(() => user.value?.role === "student");
    const isParent = computed(() => user.value?.role === "parent");

    const login = async (email, password) => {
        isLoading.value = true;
        try {
            const response = await api.post("/login", { email, password });
            const { user: userData, token: authToken } = response.data;

            user.value = userData;
            token.value = authToken;

            localStorage.setItem("auth_token", authToken);
            localStorage.setItem("user", JSON.stringify(userData));

            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                error: error.response?.data?.message || "Login failed",
            };
        } finally {
            isLoading.value = false;
        }
    };

    const register = async (userData) => {
        isLoading.value = true;
        try {
            const response = await api.post("/register", userData);
            const { user: newUser, token: authToken } = response.data;

            user.value = newUser;
            token.value = authToken;

            localStorage.setItem("auth_token", authToken);
            localStorage.setItem("user", JSON.stringify(newUser));

            return { success: true, data: response.data };
        } catch (error) {
            return {
                success: false,
                error: error.response?.data?.message || "Registration failed",
            };
        } finally {
            isLoading.value = false;
        }
    };

    const logout = async () => {
        try {
            await api.post("/logout");
        } catch (error) {
            console.error("Logout error:", error);
        } finally {
            user.value = null;
            token.value = null;
            localStorage.removeItem("auth_token");
            localStorage.removeItem("user");
        }
    };

    const fetchUser = async () => {
        if (!token.value) return;

        try {
            const response = await api.get("/user");
            user.value = response.data.user;
            localStorage.setItem("user", JSON.stringify(response.data.user));
        } catch (error) {
            console.error("Failed to fetch user:", error);
            logout();
        }
    };

    const initializeAuth = () => {
        const storedUser = localStorage.getItem("user");
        if (storedUser && token.value) {
            user.value = JSON.parse(storedUser);
        }
    };

    return {
        user,
        token,
        isLoading,
        isAuthenticated,
        isAdmin,
        isMember,
        isCoach,
        isStudent,
        isParent,
        login,
        register,
        logout,
        fetchUser,
        initializeAuth,
    };
});
