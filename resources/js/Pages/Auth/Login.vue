<template>
    <AuthLayout>
        <div class="text-center mb-10">
            <h2
                class="font-playfair text-4xl font-bold mb-3 bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent"
            >
                Selamat Datang Kembali
            </h2>
            <p class="font-montserrat text-gray-500">
                Masuk untuk melanjutkan petualangan kopi Anda.
            </p>
        </div>

        <div
            v-if="hasErrors"
            class="mb-6 bg-red-50 border border-red-300 text-red-800 p-4 text-sm"
        >
            <ul class="list-disc list-inside">
                <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
            </ul>
        </div>

        <button
            @click="loginWithGoogle"
            :disabled="form.processing"
            class="w-full mb-6 bg-white border border-gray-300 hover:bg-gray-50 text-gray-800 font-montserrat font-semibold py-3 px-4 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center space-x-3 group"
        >
            <svg class="w-5 h-5" viewBox="0 0 48 48">
                <path
                    fill="#FFC107"
                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"
                ></path>
                <path
                    fill="#FF3D00"
                    d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"
                ></path>
                <path
                    fill="#4CAF50"
                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.223,0-9.657-3.356-11.303-7.918l-6.573,4.818C9.656,39.663,16.318,44,24,44z"
                ></path>
                <path
                    fill="#1976D2"
                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C42.012,35.24,44,30.038,44,24C44,22.659,43.862,21.35,43.611,20.083z"
                ></path>
            </svg>
            <span>{{
                form.processing ? "Memproses..." : "Masuk dengan Google"
            }}</span>
        </button>

        <div class="relative mb-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-montserrat"
                    >atau masuk dengan email</span
                >
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-5">
                <div class="group">
                    <label
                        for="email"
                        class="font-montserrat text-xs font-semibold text-gray-600 mb-2 block uppercase tracking-wider"
                        >Alamat Email</label
                    >
                    <div class="relative">
                        <div
                            class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300 pointer-events-none"
                        >
                            <i class="far fa-envelope"></i>
                        </div>
                        <input
                            id="email"
                            v-model="form.email"
                            class="w-full border border-gray-300 bg-white py-3 pl-12 pr-4 font-montserrat text-base placeholder-gray-400 focus:ring-2 focus:ring-[#a07942]/50 focus:border-[#a07942] focus:outline-none transition-all duration-300"
                            type="email"
                            placeholder="nama@email.com"
                            required
                        />
                    </div>
                </div>

                <div class="group">
                    <div class="flex justify-between items-center mb-2">
                        <label
                            for="password"
                            class="font-montserrat text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >Kata Sandi</label
                        >
                        <Link
                            :href="route('login')"
                            class="text-xs text-[#a07942] hover:text-[#8b6835] font-montserrat font-medium hover:underline"
                            >Lupa kata sandi?</Link
                        >
                    </div>
                    <div class="relative">
                        <div
                            class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300 pointer-events-none"
                        >
                            <i class="fas fa-lock"></i>
                        </div>
                        <input
                            id="password"
                            v-model="form.password"
                            class="w-full border border-gray-300 bg-white py-3 pl-12 pr-12 font-montserrat text-base placeholder-gray-400 focus:ring-2 focus:ring-[#a07942]/50 focus:border-[#a07942] focus:outline-none transition-all duration-300"
                            :type="passwordFieldType"
                            placeholder="••••••••••"
                            required
                        />
                        <button
                            type="button"
                            @click="togglePasswordVisibility"
                            class="absolute right-0 top-0 h-full px-4 flex items-center text-gray-400 hover:text-[#a07942]"
                        >
                            <i
                                class="far transition-transform duration-300 hover:scale-110"
                                :class="passwordIconClass"
                            ></i>
                        </button>
                    </div>
                </div>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-gray-900 hover:bg-gray-800 text-white font-montserrat font-semibold py-3 px-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <span>{{
                    form.processing ? "MEMPROSES..." : "Masuk ke Akun"
                }}</span>
            </button>
        </form>

        <div class="text-center font-montserrat text-sm mt-8">
            <span class="text-gray-600">Belum memiliki akun?</span>
            <Link
                :href="route('register')"
                class="text-[#a07942] font-semibold ml-1 hover:text-[#8b6835] hover:underline"
            >
                Buat akun baru
            </Link>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { route } from "ziggy-js";

const props = defineProps<{
    errors: Record<string, string>;
}>();

const form = useForm({
    email: "",
    password: "",
});

const passwordFieldType = ref<"password" | "text">("password");
const passwordIconClass = computed(() => {
    return passwordFieldType.value === "password" ? "fa-eye" : "fa-eye-slash";
});
const togglePasswordVisibility = () => {
    passwordFieldType.value =
        passwordFieldType.value === "password" ? "text" : "password";
};

const hasErrors = computed(() => Object.keys(props.errors).length > 0);

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

const loginWithGoogle = () => {
    // window.location.href = route("auth.google");
};
</script>
