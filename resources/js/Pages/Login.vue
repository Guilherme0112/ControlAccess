<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50 p-6">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Bem Vindo</h2>
      <form @submit.prevent="handleLogin" class="space-y-6">
        <div>
          <label class="form-label">Email</label>
          <input
            v-model="email"
            type="email"
            required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Enter your email"
          />
        </div>
        <div>
          <label class="form-label">Senha</label>
          <input
            v-model="password"
            type="password"
            required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Enter your password"
          />
        </div>
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
        >
          Entrar
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { nextTick } from 'vue';
import { router } from '@inertiajs/vue3';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const email = ref('');
const password = ref('');

const handleLogin = async () => {
  if (auth.login(email.value, password.value)) {
    await nextTick();
    router.push('/admin');
  } else {
    alert('Invalid credentials');
  }
};

</script>