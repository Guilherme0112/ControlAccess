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
          <button class="btn btn-danger" @click="fazerLogout">Sair</button>
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
              <p v-if="erros.errors?.email_usuario" class="text-red-500 text-sm mt-1">{{ erros.errors.email_usuario[0]
              }}</p>
            </div>
            <div>
              <label class="form-label">Caixa Postal *</label>
              <input v-model="correspondencia.caixa_postal" type="text" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.caixa_postal" class="text-red-500 text-sm mt-1">{{ erros.errors.caixa_postal[0] }}
              </p>
            </div>
            <div class="form-label">
              <label for="file_input" class="block text-sm font-medium text-gray-700">
                Escolha um arquivo
              </label>
              <input id="file_input" type="file" @change="addArquivoCorrespondencia"
                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 py-2 px-3" />
              <p v-if="erros.errors?.correspondencia" class="text-red-500 text-sm mt-1">{{
                erros.errors.correspondencia[0] }}</p>
            </div>
            <div>
              <label class="form-label">Unidade *</label>
              <select v-model="correspondencia.unidade" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Selecione uma unidade</option>
                <option value="VITORIA">Vitória</option>
              </select>
              <p v-if="erros.errors?.status" class="text-red-500 text-sm mt-1">{{ erros.errors.status[0] }}</p>
            </div>
            <div>
              <label class="form-label">Status *</label>
              <select v-model="correspondencia.status" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Selecione o status</option>
                <option value="cadastrado">Cadastrado</option>
                <option value="notificado">Notificado</option>
                <option value="aprovado">Aprovado</option>
                <option value="enviado">Enviado</option>
              </select>
              <p v-if="erros.errors?.status" class="text-red-500 text-sm mt-1">{{ erros.errors.status[0] }}</p>
            </div>
            <div>
              <label class="form-label">Data de Recebimento *</label>
              <input v-model="correspondencia.data_recebimento" type="date" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.data_recebimento" class="text-red-500 text-sm mt-1">{{
                erros.errors.data_recebimento[0] }}</p>
            </div>
            <div>
              <label class="form-label">Remetente *</label>
              <input v-model="correspondencia.remetente" type="text" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <p v-if="erros.errors?.remetente" class="text-red-500 text-sm mt-1">{{
                erros.errors.remetente[0] }}</p>
            </div>
            <div class="md:col-span-2">
              <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                :class="{ 'opacity-50 cursor-not-allowed': loadSubmit }" :disabled="loadSubmit">
                Criar Registro
              </button>
            </div>
          </form>
        </Transition>
      </div>

      <!-- Tabela que exibe os dados -->
      <div class="relative overflow-x-auto shadow-md bg-white rounded-xl">
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-start pb-4">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 m-4" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"></path>
              </svg>
            </div>
            <input type="text" id="table-search"
              class="m-4 block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-ligth-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-ligth-700 dark:border-gray-600 dark:placeholder-gray-400 dark:gray-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Busque por email" v-model="termoBusca">
          </div>
          <div>
            <div class="relative w-48 p-4">
              <select id="filtroStatus" v-model="statusSelecionado"
                class="cursor-pointer appearance-none w-full py-2 px-3 text-sm border border-black-300 rounded-md bg-white focus:outline-none focus:border-blue-500">
                <option value="" selected>Todos</option>
                <option value="cadastrado">Cadastrado</option>
                <option value="notificado">Notificado</option>
                <option value="aprovado">Aprovado</option>
                <option value="enviado">Enviado</option>
              </select>
            </div>
          </div>
        </div>
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
            <tr class="bg-white" v-for="correspondencia in correspondenciasFiltradas" :key="correspondencia.id"
              v-if="correspondenciasFiltradas.length > 0">

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
                'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300': correspondencia.status === 'aprovado',
                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': correspondencia.status === 'enviado',
                'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300': !correspondencia.status
              }">
                {{ correspondencia.status || '-' }}
              </td>
              </td>
              <td>
                <div v-if="correspondencia.status === 'cadastrado'">
                  <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    @click="notificarChegada(correspondencia.email_usuario, correspondencia.id)"
                    :class="{ 'opacity-50 cursor-not-allowed': loadNotificarEmail }" :disabled="loadNotificarEmail">
                    Notificar recebimento
                  </button>
                </div>
                <div v-else-if="correspondencia.status === 'aprovado'" class="form-label">
                  <input type="file" @change="(event) => handleFileChange(event, correspondencia.id)"
                    style="width: 9rem;"
                    :disabled="loadEnviarAnexo"
                    class="block text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 py-2 px-3" />
                </div>

                <div v-else-if="correspondencia.status === 'enviado'" class="form-label">
                  <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    @click="abrirFecharVisualizarEnvio(correspondencia.correspondencia)">
                    Visualizar envio
                  </button>
                </div>
                <div v-else>
                  -
                </div>
              </td>
            </tr>
            <tr v-else>
              <td class="px-6 py-4 text-center text-gray-500" colspan="9">
                Nenhuma correspondência encontrada.
              </td>
            </tr>
          </tbody>

        </table>
      </div>
    </main>
  </div>

  <VisualizarEnvio :fechar="abrirFecharVisualizarEnvio" :src="'storage/' + correspondenciaSelecionada"
    :mostrar="statusVisualizarEnvio" />
</template>

<script setup lang="ts">
import { formatDate } from '../../utils/formatter';
import { buscarCorrespondencias, editarCorrespondencia, notificacaoChegada, salvarCorrespondencia } from '../../service/correspondencias';
import { onMounted, ref } from 'vue';
import { fazerLogout } from '../../service/usuarios';
import VisualizarEnvio from '@/Components/VisualizarEnvio.vue';
import { computed } from 'vue';

const correspondencias = ref<Correspondencia[]>([]);
const erros = ref<{ [key: string]: string[] }>({});
const statusVisualizarEnvio = ref(false);
const correspondenciaSelecionada = ref("");
const termoBusca = ref('');
const loadSubmit = ref(false);
const loadNotificarEmail = ref(false);
const loadEnviarAnexo = ref(false);
const statusSelecionado = ref('');

const correspondenciasFiltradas = computed(() => {
  return correspondencias.value.filter(c => {
    const correspondeStatus = !statusSelecionado.value || c.status?.toLowerCase() === statusSelecionado.value.toLowerCase();
    const correspondeBusca = !termoBusca.value || c.email_usuario?.toLowerCase().includes(termoBusca.value.toLowerCase());
    return correspondeStatus && correspondeBusca;
  });
});



const correspondencia = ref<Correspondencia>({
  id: null,
  nome: "",
  email_usuario: "",
  caixa_postal: "",
  unidade: "",
  status: "cadastrado",
  remetente: "",
  data_recebimento: new Date(),
  correspondencia: null
});

const addArquivoCorrespondencia = async (event: Event) => {
  const fileInput = event.target as HTMLInputElement;
  if (fileInput.files && fileInput.files.length > 0) {
    correspondencia.value.correspondencia = fileInput.files[0];
    return;
  }
  correspondencia.value.correspondencia = null;
}

const abrirFecharVisualizarEnvio = (src: string) => {
  correspondenciaSelecionada.value = src;
  statusVisualizarEnvio.value = !statusVisualizarEnvio.value;
}

const handleFileChange = async (event: Event, id: string) => {
  loadEnviarAnexo.value = true;
  try {
    const fileInput = event.target as HTMLInputElement;
    if (fileInput.files && fileInput.files.length > 0) {
      correspondencia.value.correspondencia = fileInput.files[0];
      correspondencia.value.id = id;
      correspondencia.value.status = "";
      const confirmar = confirm("Você realmente deseja enviar este arquivo?")
      if (!confirmar) return;

      const res = await editarCorrespondencia(correspondencia.value);

      const correspondenciaAtual = correspondencias.value.find(c => c.id === id);
      if (correspondenciaAtual) {
        correspondenciaAtual.status = res["status"];
        correspondenciaAtual.correspondencia = res["correspondencia"];
      }
    }
  } catch (error) {
    console.log(error)
  } finally {
      loadEnviarAnexo.value = true;
  }
};

onMounted(async () => {
  const cor = await buscarCorrespondencias();
  correspondencias.value = cor;
})

const notificarChegada = async (email: string, id: string) => {
  loadNotificarEmail.value = true;
  try {
    await notificacaoChegada(email, id);
    const correspondenciaAtual = correspondencias.value.find(c => c.id === id);
    if (correspondenciaAtual) {
      correspondenciaAtual.status = 'notificado';
    }
  } catch (error) {
    console.log(error);
  } finally {
    loadNotificarEmail.value = false;
  }
}

const submit = async () => {
  loadSubmit.value = true;
  try {
    const res = await salvarCorrespondencia(correspondencia.value);
    correspondencias.value.push(res);
    correspondencia.value = {
      id: null,
      nome: "",
      email_usuario: "",
      caixa_postal: "",
      unidade: "",
      remetente: "",
      status: "cadastrado",
      data_recebimento: new Date(),
      correspondencia: null
    };
  } catch (error: any) {
    // console.log(error)
    erros.value = error;
  } finally {
    loadSubmit.value = false;
  }
}

const mostrarFormulario = ref(false)
const toggleFormulario = () => {
  mostrarFormulario.value = !mostrarFormulario.value
}

</script>