<template>
    <div
        class="flex min-h-screen w-full bg-gradient-to-br from-[#f8f7f4] via-[#faf9f6] to-[#f5f4f1] p-10 shadow-xl px-20"
    >
        <div
            class="hidden lg:block lg:w-1/2 bg-cover bg-center relative overflow-hidden bg-coklat shadow-lg"
        >
            <div
                class="relative h-full flex flex-col justify-between p-12 z-10"
            >
                <div class="text-white">
                    <div class="flex items-center space-x-2 mb-2">
                        <img
                            src="/images/logo.png"
                            alt="logo"
                            class="h-12 transition-all duration-300 ease-in-out"
                        />
                        <h1 class="font-bold text-3xl">Sruput</h1>
                    </div>
                </div>

                <div class="">
                    <img src="/images/login.png" alt="" />
                </div>
            </div>
        </div>

        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-6 relative overflow-hidden shadow-lg bg-white"
        >
            <div class="w-full max-w-md relative z-10">
                <slot />

                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-500 font-montserrat">
                        &copy; 2025 Sruput. Seluruh hak cipta dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
// Script di layout hanya berisi apa yang dibutuhkan oleh layout itu sendiri.
const props = withDefaults(
    defineProps<{
        backgroundImageUrl?: string;
    }>(),
    {
        backgroundImageUrl: "/images/default-auth-bg.jpg",
    }
);
</script>
