<style scoped>
.expand-enter-active,
.expand-leave-active {
  transition: all 0.4s ease;
  overflow: hidden;
}

.expand-enter-from,
.expand-leave-to {
  max-height: 0;
  opacity: 0;
}

.expand-enter-to,
.expand-leave-from {
  max-height: 1000px;
  opacity: 1;
}
</style>

<template>

  <!-- Header do dashboard -->
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

      <!-- Formulário -->
      <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <!-- Cabeçalho clicável -->
        <div @click="toggleFormulario" class="flex justify-between items-center cursor-pointer">
          <h2 class="text-xl font-semibold text-gray-900">Criar novo registro</h2>
          <svg :class="['w-5 h-5 transition-transform', { 'rotate-180': mostrarFormulario }]" fill="none"
            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </div>

        <!-- Transição do formulário -->
        <Transition name="expand">
          <form v-show="mostrarFormulario" @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- todos os campos permanecem os mesmos -->
            <div>
              <label class="form-label">Nome *</label>
              <input v-model="correspondencia.nome" type="text" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.nome" class="text-red-500 text-sm mt-1">{{ erros.errors.nome[0] }}</p>
            </div>
            <div>
              <label class="form-label">Email *</label>
              <input v-model="correspondencia.email_usuario" type="email" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.email_usuario" class="text-red-500 text-sm mt-1">{{ erros.errors.email_usuario[0] }}</p>
            </div>
            <div>
              <label class="form-label">Caixa Postal *</label>
              <input v-model="correspondencia.caixa_postal" type="text" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.caixa_postal" class="text-red-500 text-sm mt-1">{{ erros.errors.caixa_postal[0] }}</p>
              </div>
            <div class="form-label">
              <label for="file_input" class="block text-sm font-medium text-gray-700">
                Escolha um arquivo
              </label>
              <input id="file_input" type="file"
                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 py-2 px-3" />
            </div>
            <div>
              <label class="form-label">Unidade *</label>
              <input v-model="correspondencia.unidade" type="text" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.unidade" class="text-red-500 text-sm mt-1">{{ erros.errors.unidade[0] }}</p>
              </div>
            <div>
              <label class="form-label">Status *</label>
              <select v-model="correspondencia.status" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Selecione o status</option>
                <option value="recebido">Recebido</option>
                <option value="enviado">Enviado</option>
                <option value="notificado">Notificado</option>
              </select>
              <p v-if="erros.errors?.status" class="text-red-500 text-sm mt-1">{{erros.errors.status[0] }}</p>
            </div>
            <div>
              <label class="form-label">Data de Recebimento *</label>
              <input v-model="correspondencia.data_recebimento" type="date" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.data_recebimento" class="text-red-500 text-sm mt-1">{{ erros.errors.data_recebimento[0] }}</p>
              </div>
            <div class="md:col-span-2">
              <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                Criar Registro
              </button>
            </div>
          </form>
        </Transition>
      </div>


      <!-- Tabela que exibe os dados -->
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
              <td class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full" :class="{
                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300': correspondencia.status === 'recebido',
                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300': correspondencia.status === 'notificado',
                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': correspondencia.status === 'enviado',
                'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300': !correspondencia.status
              }">
                {{ correspondencia.status || '-' }}
              </td>

              <td>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                  Notificar recebimento
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { formatDate } from '../../utils/formatter';
import { buscarCorrespondencias, salvarCorrespondencia } from '../../service/correspondencias';
import { onMounted, ref } from 'vue';

const correspondencias = ref<Correspondencia[]>([]);
const erros = ref<{ [key: string]: string[] }>({});

const correspondencia = ref<Correspondencia>({
  id: null,
  nome: "",
  email_usuario: "",
  caixa_postal: "",
  unidade: "",
  status: "recebido",
  data_recebimento: new Date(),
  correspondencia: null
});


onMounted(async () => {
  const cor = await buscarCorrespondencias();
  correspondencias.value = cor;
})


const submit = async () => {
  try {
    const res = await salvarCorrespondencia(correspondencia.value);
    correspondencias.value.push(res);
  } catch (error: any) {

    erros.value = error;
  }
}

const mostrarFormulario = ref(false)

const toggleFormulario = () => {
  mostrarFormulario.value = !mostrarFormulario.value
}

</script>
