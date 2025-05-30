<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <h1 class="text-2xl font-bold text-gray-900">My Records</h1>
          <button @click="logout" class="btn btn-danger">Sair</button>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="table-header">Name</th>
                <th class="table-header">Email</th>
                <th class="table-header">Postal Box</th>
                <th class="table-header">Status</th>
                <th class="table-header">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="record in userRecords" :key="record.id" class="hover:bg-gray-50">
                <td class="table-cell">{{ record.name }}</td>
                <td class="table-cell">{{ record.email }}</td>
                <td class="table-cell">{{ record.postalBox }}</td>
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
                  <button
                    v-if="record.status === 'enviado'"
                    class="btn btn-primary"
                  >
                    Open Attachment
                  </button>
                </td>
              </tr>
              <tr v-if="userRecords.length === 0">
                <td colspan="5" class="table-cell text-center text-gray-500">
                  No records found
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