<template>
    <AuthLayout background-image-url="/images/login.jpg">
        <div class="text-center mb-8">
            <h2
                class="font-playfair text-3xl font-bold text-[#1a1a1a] mb-3 bg-gradient-to-r from-[#1a1a1a] to-[#4a4a4a] bg-clip-text text-transparent"
            >
                Buat Akun Baru
            </h2>
            <p class="font-montserrat text-gray-600 text-sm">
                Mulai perjalanan kopi Anda bersama kami hari ini
            </p>
        </div>

        <div
            v-if="hasErrors"
            class="mb-6 bg-red-50/80 backdrop-blur-sm border border-red-200/50 text-red-700 p-4 rounded-2xl text-sm"
        >
            <ul class="list-disc pl-4">
                <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
            </ul>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-2">
                <div class="group">
                    <label
                        for="name"
                        class="font-montserrat text-xs font-semibold text-gray-700 ml-2 mb-2 block uppercase tracking-wider"
                        >Nama </label
                    >
                    <div class="relative">
                        <div
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300"
                        >
                            <i class="far fa-user"></i>
                        </div>
                        <input
                            id="name"
                            v-model="form.name"
                            class="w-full border-2 border-gray-200 bg-gray-50/50 rounded-2xl py-3 pl-12 pr-4 font-montserrat text-sm focus:ring-0 focus:border-[#a07942] focus:bg-white"
                            type="text"
                            placeholder="John Doe"
                            required
                        />
                    </div>
                </div>

                <div class="group">
                    <label
                        for="email"
                        class="font-montserrat text-xs font-semibold text-gray-700 ml-2 mb-2 block uppercase tracking-wider"
                        >Alamat Email</label
                    >
                    <div class="relative">
                        <div
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300"
                        >
                            <i class="far fa-envelope"></i>
                        </div>
                        <input
                            id="email"
                            v-model="form.email"
                            class="w-full border-2 border-gray-200 bg-gray-50/50 rounded-2xl py-3 pl-12 pr-4 font-montserrat text-sm focus:ring-0 focus:border-[#a07942] focus:bg-white"
                            type="email"
                            placeholder="nama@email.com"
                            required
                        />
                    </div>
                </div>

                <div class="group">
                    <label
                        for="password"
                        class="font-montserrat text-xs font-semibold text-gray-700 ml-2 mb-2 block uppercase tracking-wider"
                        >Kata Sandi</label
                    >
                    <div class="relative">
                        <div
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300"
                        >
                            <i class="fas fa-lock"></i>
                        </div>
                        <input
                            id="password"
                            v-model="form.password"
                            class="w-full border-2 border-gray-200 bg-gray-50/50 rounded-2xl py-3 pl-12 pr-12 font-montserrat text-sm focus:outline-none focus:ring-0 focus:border-[#a07942] focus:bg-white"
                            type="password"
                            placeholder="Minimal 8 karakter"
                            required
                        />
                    </div>
                </div>

                <div class="group">
                    <label
                        for="password_confirmation"
                        class="font-montserrat text-xs font-semibold text-gray-700 ml-2 mb-2 block uppercase tracking-wider"
                        >Konfirmasi Kata Sandi</label
                    >
                    <div class="relative">
                        <div
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300"
                        >
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            class="w-full border-2 border-gray-200 bg-gray-50/50 rounded-2xl py-3 pl-12 pr-4 font-montserrat text-sm focus:ring-0 focus:border-[#a07942] focus:bg-white"
                            type="password"
                            placeholder="Ulangi kata sandi"
                            required
                        />
                    </div>
                </div>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-gradient-to-r from-[#1a1a1a] to-[#2d2d2d] hover:from-[#2d2d2d] hover:to-[#1a1a1a] text-white font-montserrat font-semibold py-3 rounded-2xl transition-all duration-500 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 disabled:opacity-50"
            >
                <span>{{
                    form.processing ? "Memproses..." : "Daftar Akun"
                }}</span>
            </button>
        </form>

        <div class="text-center font-montserrat text-sm mt-8">
            <span class="text-gray-600">Sudah memiliki akun?</span>
            <Link
                :href="route('login')"
                class="text-[#a07942] font-semibold ml-2 hover:text-[#8b6835] hover:underline"
            >
                Masuk di sini
            </Link>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import AuthLayout from "@/Layouts/AuthLayout.vue"; // <-- Import Layout

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const props = defineProps<{
    errors: Record<string, string>;
}>();

// Cek apakah ada error dari backend
const hasErrors = computed(() => Object.keys(props.errors).length > 0);

// Fungsi untuk submit form register
const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>
