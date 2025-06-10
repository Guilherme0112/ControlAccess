<template>
  <div
    v-if="mostrar"
    class="fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center"
  >
    <div
      class="relative bg-white rounded-xl shadow-lg max-w-3xl w-full p-4 h-[500px] flex items-center justify-center"
    >
      <!-- Botão de fechar -->
      <button
        @click="fechar"
        class="absolute top-1 right-3 text-gray-600 hover:text-gray-800 text-4xl font-bold"
        aria-label="Fechar modal"
      >
        &times;
      </button>

      <!-- Imagem -->
      <img
        :src="src"
        alt="Visualização da correspondência"
        class="rounded-md object-contain max-h-full max-w-full"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  src: string
  mostrar: boolean
  fechar: () => void
}>()
</script>
