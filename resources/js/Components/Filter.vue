<template>
   <div class="bg-white shadow rounded-lg mx-3 my-4">
    <div class="flex flex-wrap items-center gap-2 p-4 shadow-md rounded-lg">
      <slot name="inputFilter" />
      <slot name="buttonFilter" />
    </div>
  </div>
</template>

<script setup>

import { ref } from 'vue'

const searchQuery = ref('')
const groups = ref([]) // Substitua com seus dados reais
const profiles = ref([]) // Substitua com seus dados reais

const onSearch = () => {
  // Implemente a lógica de busca aqui
}
</script>
