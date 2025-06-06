<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50 p-6">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
      <div class="mb-9">
        <img src="logo.png" alt="Logo Athena Office">
      </div>
      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label class="form-label">Email</label>
          <input v-model="login.email" type="email" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Enter your email" />
        </div>
        <div>
          <label class="form-label">Senha</label>
          <input v-model="login.senha" type="password" required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Enter your password" />
        </div>
        <p v-if="errors[0]" class="text-red-500 text-sm mt-1">{{ errors[0] }}</p>
        <button type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
          Entrar
        </button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import type { LoginRequest } from "../../types/requests/LoginRequest"
import { fazerLogin } from '../../service/usuarios';
import { router } from '@inertiajs/vue3';

const errors = ref<{ auth?: string[] }>({})
const login = ref<LoginRequest>({
  email: '',
  senha: ''
})

const submit = async () => {
  try {
    await fazerLogin(login.value);
    router.visit("/admin");
  } catch (e: any) {
    // console.log(e)
    errors.value = e.errors.auth
  }
};
</script>