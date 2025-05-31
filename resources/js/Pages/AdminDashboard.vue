<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
          <button class="btn btn-danger">Sair</button>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Criar novo registro</h2>
        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="form-label">Nome *</label>
            <input v-model="newRecord.name" type="text" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Email *</label>
            <input v-model="newRecord.email" type="email" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Caixa Postal *</label>
            <input v-model="newRecord.postalBox" type="text" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div class="form-label">
            <label for="file_input" class="block text-sm font-medium text-gray-700">
              Escolha um arquivo
            </label>
            <input id="file_input" type="file"
              class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 py-2 px-3"/>
          </div>
          <div>
            <label class="form-label">Unidade *</label>
            <input v-model="newRecord.unit" type="text" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Data de Recebimento *</label>
            <input v-model="newRecord.receivedDate" type="date" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div class="md:col-span-2">
            <button type="submit"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
              Criar Registro
            </button>
          </div>
        </form>
      </div>

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
                    Notificar recebimento
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
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';


const router = useRouter();
const auth = useAuthStore();

const newRecord = ref<RecordForm>({
  name: '',
  email: '',
  postalBox: '',
  attachment: '',
  unit: '',
  receivedDate: '',
});

</script>
