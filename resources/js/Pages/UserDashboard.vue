<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <h1 class="text-2xl font-bold text-gray-900">Minhas Correspondências</h1>
          <button class="btn btn-danger" @click="fazerLogout">Sair</button>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Records Table -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">

        <!-- Container flex para centralizar horizontalmente -->
        <div class="relative overflow-x-auto shadow-md bg-white rounded-xl">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
          <thead class="text-xs text-gray-900 uppercase">
            <tr>
              <th scope="col" class="px-6 py-3">
                Nome
              </th>
              <th scope="col" class="px-6 py-3">
                Email
              </th>
              <th scope="col" class="px-6 py-3">
                Caixa Postal
              </th>
              <th scope="col" class="px-6 py-3">
                Unidade
              </th>
              <th scope="col" class="px-6 py-3">
                Data de Recebimento
              </th>
              <th scope="col" class="px-6 py-3">
                Remetente
              </th>
              <th scope="col" class="px-6 py-3">
                Status
              </th>
              <th scope="col" class="px-6 py-3">
                Ações
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white" v-for="correspondencia in correspondencias" :key="correspondencia.id">
              <td class="px-6 py-4">
                {{ correspondencia.nome || "-" }}
              </td>
              <td class="px-6 py-4">
                {{ correspondencia.email_usuario || "-" }}
              </td>
              <td class="px-6 py-4">
                {{ correspondencia.caixa_postal || "-" }}
              </td>
              <td class="px-6 py-4">
                {{ correspondencia.unidade || "-" }}
              </td>
              <td class="px-6 py-4">
                {{ formatDate(String(correspondencia.data_recebimento)) || "-" }}
              </td>
              <td class="px-6 py-4">
                {{ correspondencia.remetente || "-" }}
              </td>
              <td>
                <td class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full" :class="{
                  'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300': correspondencia.status === 'cadastrado',
                  'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300': correspondencia.status === 'notificado',
                  'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': correspondencia.status === 'enviado',
                  'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300': !correspondencia.status
                }">
                  {{ correspondencia.status || '-' }}
                </td>
              </td>
              <td>
                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
import { fazerLogout } from '../../service/usuarios';
import { buscarCorrespondencias } from '../../service/correspondencias';
import { formatDate } from '../../utils/formatter';
import { onMounted, ref } from 'vue';

const correspondencias = ref<Correspondencia[]>([]);

onMounted(async() => {
  const cor = await buscarCorrespondencias();
  correspondencias.value = cor;
})
</script>