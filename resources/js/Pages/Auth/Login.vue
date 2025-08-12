<template>
  <Head title="Masuk" />
  
  <LoginForm 
    :errors="errors" 
    :is-processing="form.processing"
    background-image-url="/images/login.jpg"
    @submit="handleLogin"
  />
</template>

<script setup lang="ts">
import LoginForm from '@/components/ui/Auth/LoginForm.vue';
import { LoginPayload } from '@/types/auth';
import { Head, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

// Definisikan props yang diterima dari Laravel (jika ada)
defineProps<{
  errors: Record<string, string>;
}>();

// Gunakan 'useForm' dari Inertia untuk mengelola state form
const form = useForm({
  email: '',
  password: '',
  role: 'customer',
});

const handleLogin = (payload:LoginPayload) => {
  form.email = payload.email;
  form.password = payload.password;
  form.role = payload.role;

  // Kirim data ke route 'login' di Laravel
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>