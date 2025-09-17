<template>
    <AuthLayout background-image-url="/images/register-bg.jpg">
        <div class="text-center mb-8">
            <h2
                class="font-playfair text-4xl font-bold mb-3 bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent"
            >
                Buat Akun Baru
            </h2>
            <p class="font-montserrat text-gray-500">
                Mulai perjalanan kopi Anda bersama kami hari ini.
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

        <form @submit.prevent="submit" class="space-y-5">
            <div class="group">
                <label
                    for="name"
                    class="font-montserrat text-xs font-semibold text-gray-600 mb-2 block uppercase tracking-wider"
                    >Nama Lengkap</label
                >
                <div class="relative">
                    <div
                        class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300 pointer-events-none"
                    >
                        <i class="far fa-user"></i>
                    </div>
                    <input
                        id="name"
                        v-model="form.name"
                        class="w-full border border-gray-300 bg-white py-3 pl-12 pr-4 font-montserrat text-base placeholder-gray-400 focus:ring-2 focus:ring-[#a07942]/50 focus:border-[#a07942] focus:outline-none transition-all duration-300"
                        type="text"
                        placeholder="John Doe"
                        required
                    />
                </div>
            </div>

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
                <label
                    for="password"
                    class="font-montserrat text-xs font-semibold text-gray-600 mb-2 block uppercase tracking-wider"
                    >Kata Sandi</label
                >
                <div class="relative">
                    <div
                        class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300 pointer-events-none"
                    >
                        <i class="fas fa-lock"></i>
                    </div>
                    <input
                        id="password"
                        v-model="form.password"
                        class="w-full border border-gray-300 bg-white py-3 pl-12 pr-4 font-montserrat text-base placeholder-gray-400 focus:ring-2 focus:ring-[#a07942]/50 focus:border-[#a07942] focus:outline-none transition-all duration-300"
                        type="password"
                        placeholder="Minimal 8 karakter"
                        required
                    />
                </div>
            </div>

            <div class="group">
                <label
                    for="password_confirmation"
                    class="font-montserrat text-xs font-semibold text-gray-600 mb-2 block uppercase tracking-wider"
                    >Konfirmasi Kata Sandi</label
                >
                <div class="relative">
                    <div
                        class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 group-focus-within:text-[#a07942] transition-colors duration-300 pointer-events-none"
                    >
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        class="w-full border border-gray-300 bg-white py-3 pl-12 pr-4 font-montserrat text-base placeholder-gray-400 focus:ring-2 focus:ring-[#a07942]/50 focus:border-[#a07942] focus:outline-none transition-all duration-300"
                        type="password"
                        placeholder="Ulangi kata sandi"
                        required
                    />
                </div>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-gray-900 hover:bg-gray-800 text-white font-montserrat font-semibold py-3 px-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed mt-4"
            >
                <span>{{
                    form.processing ? "MEMPROSES..." : "Daftar Akun"
                }}</span>
            </button>
        </form>

        <div class="text-center font-montserrat text-sm mt-4">
            <span class="text-gray-600">Sudah memiliki akun?</span>
            <Link
                :href="route('login')"
                class="text-[#a07942] font-semibold ml-1 hover:text-[#8b6835] hover:underline"
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
import AuthLayout from "@/Layouts/AuthLayout.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const props = defineProps<{
    errors: Record<string, string>;
}>();

const hasErrors = computed(() => Object.keys(props.errors).length > 0);

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>
