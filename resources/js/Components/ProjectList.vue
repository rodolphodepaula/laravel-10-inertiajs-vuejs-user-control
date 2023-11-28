<template>
  <div class="p-4 bg-white rounded-lg shadow-md">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Projetos</h3>
    <ul>
      <li v-for="project in projects" :key="project.id" class="mb-3 p-3 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100">
        <span class="font-medium text-gray-700">{{ project.name }}</span>
        <span :class="statusClass(project.status)" class="px-3 py-1 rounded-full text-xs font-semibold">{{ project.status }}</span>
        <button @click="viewDetails(project.id)" class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 rounded-lg text-sm px-4 py-2">Ver Detalhes</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const projects = ref([
  { 
    id: 1, 
    name: 'Torres do Parque', 
    status: 'Em Andamento', 
    budget: 1200000, 
    spent: 400000, 
    progress: 50, 
    details: 'Condomínio residencial com área de lazer completa.'
  },
  { 
    id: 2, 
    name: 'Edifício Solaris', 
    status: 'Concluído', 
    budget: 900000, 
    spent: 850000, 
    progress: 100, 
    details: 'Edifício comercial com localização central e infraestrutura moderna.'
  },
  { 
    id: 3, 
    name: 'Vila das Flores', 
    status: 'Planejamento', 
    budget: 500000, 
    spent: 10000, 
    progress: 10, 
    details: 'Complexo de casas térreas com foco em sustentabilidade e áreas verdes.'
  },
  // ...outros projetos
]);


const statusClass = (status) => {
  return {
    'text-green-800 bg-green-200': status === 'Concluído',
    'text-yellow-800 bg-yellow-200': status === 'Em Andamento',
    // adicione mais status conforme necessário
  };
};

const viewDetails = (projectId) => {
  // Lógica para ver detalhes do projeto
};
</script>

<style scoped>
/* Se precisar de estilos adicionais que não estão no Tailwind, adicione-os aqui */
</style>
