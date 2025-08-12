<template>
  <div class="flex min-h-screen w-full bg-[#f8f7f4]">
    <div
      class="hidden lg:block lg:w-1/2 bg-cover bg-center"
      :style="{ backgroundImage: `url(${props.backgroundImageUrl})` }"
    >
      <div
        class="h-full flex flex-col justify-between p-12 bg-gradient-to-t from-black/60 via-black/40 to-transparent"
      >
        <div class="text-white">
          <h2 class="font-playfair text-3xl font-bold">COFFEE SHOP</h2>
        </div>
        <div class="text-white max-w-md">
          <h3 class="font-playfair text-4xl font-bold mb-4">Nikmati Kopi Premium Pilihan</h3>
          <p class="font-montserrat opacity-80">
            Rasakan cita rasa terbaik dari biji kopi pilihan yang disajikan dengan penuh cinta dan dedikasi.
          </p>
        </div>
      </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
      <div class="w-full max-w-md">
        <div class="lg:hidden text-center mb-10">
          <h1 class="font-playfair text-3xl font-bold text-[#1a1a1a]">TERRA</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
          <div class="text-center mb-8">
            <h2 class="font-playfair text-3xl font-semibold text-[#1a1a1a] mb-2">Selamat Datang Kembali</h2>
            <p class="font-montserrat text-gray-500 text-sm">Masuk ke akun Anda untuk melanjutkan</p>
          </div>

          <div v-if="hasErrors" class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-sm">
            <ul class="list-disc pl-4">
              <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
            </ul>
          </div>
          
          <form @submit.prevent="submitForm" class="space-y-6">
            <div class="space-y-5">
              <div class="relative">
                <label for="email" class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">
                  Alamat Email
                </label>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="far fa-envelope"></i>
                  </span>
                  <input
                    id="email"
                    v-model="form.email"
                    class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                    type="email"
                    name="email"
                    placeholder="email@anda.com"
                    required
                  />
                </div>
              </div>

              <div class="relative">
                <div class="flex justify-between items-center mb-1">
                  <label for="password" class="font-montserrat text-xs font-medium text-gray-700 ml-1">
                    Kata Sandi
                  </label>
                  <Link :href="route('login')" class="text-xs text-[#a07942] hover:underline font-montserrat">
                    Lupa kata sandi?
                  </Link>
                </div>
                <div class="relative">
                  <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-lock"></i>
                  </span>
                  <input
                    id="password"
                    v-model="form.password"
                    class="w-full border border-gray-200 bg-gray-50/50 rounded-lg py-3 pl-10 pr-4 font-montserrat text-sm focus:outline-none focus:ring-2 focus:ring-[#a07942] focus:border-transparent"
                    :type="passwordFieldType"
                    name="password"
                    placeholder="••••••••"
                    required
                  />
                  <button type="button" @click="togglePasswordVisibility" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="far" :class="passwordIconClass"></i>
                  </button>
                </div>
              </div>

              <div class="relative">
                <label class="font-montserrat text-xs font-medium text-gray-700 ml-1 mb-1 block">Masuk Sebagai</label>
                <div class="flex space-x-4 px-4">
                  <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" v-model="form.role" value="customer" class="form-radio text-[#a07942] focus:ring-[#a07942]" required>
                    <span class="font-montserrat text-sm text-gray-700">Customer</span>
                  </label>
                  <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" v-model="form.role" value="admin" class="form-radio text-[#a07942] focus:ring-[#a07942]" required>
                    <span class="font-montserrat text-sm text-gray-700">Admin</span>
                  </label>
                </div>
              </div>
            </div>

            <button
              type="submit"
              :disabled="isProcessing"
              class="w-full bg-[#1a1a1a] text-white font-montserrat font-medium py-3 rounded-lg hover:bg-[#333] transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ isProcessing ? 'Memproses...' : 'Masuk' }}
            </button>
          </form>

          <div class="text-center font-montserrat text-sm mt-6">
            <span class="text-gray-600">Belum memiliki akun?</span>
            <Link :href="route('register')" class="text-[#a07942] font-medium ml-1 hover:underline">
              Buat akun
            </Link>
          </div>
        </div>

        <div class="mt-8 text-center">
          <p class="text-xs text-gray-500 font-montserrat">
            &copy; 2025 Coffee Shop. Seluruh hak cipta dilindungi.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { LoginPayload } from '@/types/auth';



// Props: Data yang diterima dari komponen parent (halaman Login)
const props = withDefaults(defineProps<{
  errors?: Record<string, string>;
  isProcessing?: boolean;
  backgroundImageUrl?: string;
}>(), {
  errors: () => ({}),
  isProcessing: false,
  backgroundImageUrl: '/images/login.jpg', 
});

// Emits: Event yang dikirim ke komponen parent
const emit = defineEmits<{
  (e: 'submit', payload: LoginPayload): void;
}>();

// State reaktif untuk menampung data form
const form = reactive<LoginPayload>({
  email: '',
  password: '',
  role: 'customer', // Nilai default
});

// State untuk toggle visibilitas password
const passwordFieldType = ref<'password' | 'text'>('password');

// Computed property untuk kelas ikon mata (lebih bersih)
const passwordIconClass = computed(() => {
  return passwordFieldType.value === 'password' ? 'fa-eye' : 'fa-eye-slash';
});

// Computed property untuk memeriksa apakah ada error
const hasErrors = computed(() => Object.keys(props.errors).length > 0);

// Method untuk mengubah visibilitas password
const togglePasswordVisibility = () => {
  passwordFieldType.value = passwordFieldType.value === 'password' ? 'text' : 'password';
};

// Method untuk mengirim form
const submitForm = () => {
  emit('submit', form);
};
</script>

<style scoped>
/* Anda dapat menambahkan style spesifik komponen di sini jika perlu */
/* Contoh untuk form-radio agar warnanya konsisten */
.form-radio {
  color: #a07942;
}
.form-radio:focus {
  ring: #a07942;
}
</style>