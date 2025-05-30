import { defineStore } from 'pinia';
import { ref } from 'vue';

interface User {
  email: string;
  role: 'admin' | 'user';
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null);

  const login = (email: string, password: string) => {
    // Simplified login logic - in real app, this would validate against a backend
    if (email === 'admin@example.com' && password === 'admin') {
      user.value = { email, role: 'admin' };
      return true;
    } else if (email === 'user@example.com' && password === 'user') {
      user.value = { email, role: 'user' };
      return true;
    }
    return false;
  };

  const logout = () => {
    user.value = null;
  };

  return { user, login, logout };
});