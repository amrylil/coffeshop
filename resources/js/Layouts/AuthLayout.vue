<template>
  <div class="flex min-h-screen w-full bg-gradient-to-br from-[#f8f7f4] via-[#faf9f6] to-[#f5f4f1] p-10 shadow-2xl">
    <div
      class="hidden lg:block lg:w-1/2 bg-cover bg-center relative overflow-hidden rounded-l-2xl"
      :style="{ backgroundImage: `url(${props.backgroundImageUrl})` }"
    >
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
      <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
      
      <div class="relative h-full flex flex-col justify-between p-12 z-10">
        <div class="text-white">
          <div class="flex items-center space-x-3 mb-2">
            <div class="w-2 h-2 bg-[#a07942] rounded-full animate-pulse"></div>
            <h2 class="font-playfair text-3xl font-bold tracking-wider">TERRA COFFEE</h2>
          </div>
          <div class="w-20 h-1 bg-gradient-to-r from-[#a07942] to-transparent rounded-full"></div>
        </div>
        
        <div class="text-white max-w-lg">
          <h3 class="font-playfair text-5xl font-bold mb-6 leading-tight">
            Nikmati Kopi <span class="text-[#d4af37]">Premium</span> Pilihan
          </h3>
          <p class="font-montserrat opacity-90 text-lg leading-relaxed">
            Rasakan cita rasa terbaik dari biji kopi pilihan yang disajikan dengan penuh cinta dan dedikasi untuk setiap tegukan yang sempurna.
          </p>
          </div>
      </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 relative overflow-hidden rounded-r-2xl bg-white"
    >
      <div class="w-full max-w-md relative z-10">
        
        <slot />

        <div class="mt-8 text-center">
          <p class="text-xs text-gray-500 font-montserrat">
            &copy; 2025 Terra Coffee Shop. Seluruh hak cipta dilindungi.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Script di layout hanya berisi apa yang dibutuhkan oleh layout itu sendiri.
const props = withDefaults(defineProps<{
  backgroundImageUrl?: string;
}>(), {
  backgroundImageUrl: '/images/default-auth-bg.jpg', 
});
</script>