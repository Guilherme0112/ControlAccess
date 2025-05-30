<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
          <button @click="logout" class="btn btn-danger">Sair</button>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Criar novo registro</h2>
        <form @submit.prevent="createRecord" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="form-label">Nome</label>
            <input v-model="newRecord.name" type="text" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Email</label>
            <input v-model="newRecord.email" type="email" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Caixa Postal</label>
            <input v-model="newRecord.postalBox" type="text" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Anexo</label>
            <input v-model="newRecord.attachment" type="text" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Unidade</label>
            <input v-model="newRecord.unit" type="text" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div>
            <label class="form-label">Data de Recebimento</label>
            <input v-model="newRecord.receivedDate" type="date" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
          </div>
          <div class="md:col-span-2">
            <button type="submit" class="btn btn-primary w-full md:w-auto">
              Criar Registro
            </button>
          </div>
        </form>
      </div>

      <!-- Records Table -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="table-header">Nome</th>
                <th class="table-header">Email</th>
                <th class="table-header">Status</th>
                <th class="table-header">Ações</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="record in records" :key="record.id" class="hover:bg-gray-50">
                <td class="table-cell">{{ record.name }}</td>
                <td class="table-cell">{{ record.email }}</td>
                <td class="table-cell">
                  <span :class="{
                    'px-2 py-1 text-xs font-medium rounded-full': true,
                    'bg-yellow-100 text-yellow-800': record.status === 'pendente',
                    'bg-green-100 text-green-800': record.status === 'recebido',
                    'bg-blue-100 text-blue-800': record.status === 'enviado'
                  }">
                    {{ record.status }}
                  </span>
                </td>
                <td class="table-cell">
                  <button v-if="record.status === 'pendente'" @click="updateStatus(record.id, 'recebido')"
                    class="btn btn-success mr-2">
                    Notificar recebimento
                  </button>
                  <button v-if="record.status === 'recebido'" @click="updateStatus(record.id, 'enviado')"
                    class="btn btn-primary">
                    Enviar anexo por email
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
import { useAuthStore } from '../stores/auth';
import { useRecordsStore } from '../stores/records';

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

const createRecord = () => {
  recordsStore.addRecord({
    ...newRecord.value,
    status: 'pendente'
  });

  newRecord.value = {
    name: '',
    email: '',
    postalBox: '',
    attachment: '',
    unit: '',
    receivedDate: '',
  };
};

const updateStatus = (id: string, status: 'recebido' | 'enviado') => {
  recordsStore.updateStatus(id, status);
};

const logout = () => {
  auth.logout();
  router.push('/login');
};

const records = recordsStore.records;
</script>
