<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <h1 class="text-2xl font-bold text-gray-900">Minhas Correspondências</h1>
          <button @click="logout" class="btn btn-danger">Sair</button>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Records Table -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">

        <!-- Container flex para centralizar horizontalmente -->
        <div class="overflow-x-auto flex justify-center">

          <table class="w-full table-fixed border-separate border-spacing-x-10 border-spacing-y-3">
            <thead>
              <tr>
                <th class="text-left text-gray-700">Nome</th>
                <th class="text-left text-gray-700">Email</th>
                <th class="text-left text-gray-700">Caixa Postal</th>
                <th class="text-left text-gray-700">Unidade</th>
                <th class="text-left text-gray-700">Data de Recebimento</th>
                <th class="text-left text-gray-700">Status</th>
                <th class="text-left text-gray-700">Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr class="hover:bg-gray-50">
                <td class="text-gray-700">Teste</td>
                <td class="text-gray-700">Email@email.com</td>
                <td class="text-gray-700">157</td>
                <td class="text-gray-700">Vitória</td>
                <td class="text-gray-700">30/03/2025</td>
                <td class="text-gray-700">Enviado</td>
                <td>
                  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Aprovar Abertura
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { useRecordsStore } from '../../stores/records';

const router = useRouter();
const auth = useAuthStore();
const recordsStore = useRecordsStore();

const userRecords = computed(() => {
  return recordsStore.getRecordsByEmail(auth.user?.email || '');
});

const logout = () => {
  auth.logout();
  router.push('/login');
};
</script>