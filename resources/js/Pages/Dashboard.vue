<script setup>
import { onMounted } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { Chart, registerables } from 'chart.js'
Chart.register(...registerables)

const { totalUsers, totalCompanies } = usePage().props
onMounted(() => {
  createBarChart()
})

const createBarChart = () => {
  const ctx = document.getElementById('barChart').getContext('2d')
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Usuários', 'Empresas'],
      datasets: [
        {
          label: 'Quantidade',
          data: [totalUsers, totalCompanies],
          backgroundColor: ['#3490dc', '#63c964'],
          borderColor: ['#005bb5', '#43A047'],
          borderWidth: 1,
          barThickness: 150,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      maintainAspectRatio: false
    },
  })
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-4">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-3 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-lg font-semibold mb-4">Resumo</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-500 text-white p-4 rounded-lg">
                                <p class="text-lg font-semibold">Total de Usuários</p>
                                <p class="text-3xl">{{ totalUsers }}</p>
                            </div>
                            <div class="bg-green-500 text-white p-4 rounded-lg">
                                <p class="text-lg font-semibold">Total de Empresas</p>
                                <p class="text-3xl">{{ totalCompanies }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
