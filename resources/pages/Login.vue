<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50 p-6">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Welcome Back</h2>
      <form @submit.prevent="handleLogin" class="space-y-6">
        <div>
          <label class="form-label">Email Address</label>
          <input
            v-model="email"
            type="email"
            required
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Enter your email"
          />
        </div>
        <div>
          <label class="form-label">Password</label>
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
          class="w-full btn btn-primary py-3 text-base"
        >
          Sign In
        </button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const auth = useAuthStore();

const email = ref('');
const password = ref('');

const handleLogin = () => {
  if (auth.login(email.value, password.value)) {
    router.push(auth.user?.role === 'admin' ? '/admin' : '/user');
  } else {
    alert('Invalid credentials');
  }
};
</script>