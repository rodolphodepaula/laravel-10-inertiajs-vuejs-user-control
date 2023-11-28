<template>
  <div class="reservations-chart">
    <line-chart :chart-data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import { Line } from 'vue-chartjs';
import { defineComponent, reactive, toRefs } from 'vue';

export default defineComponent({
  components: {
    LineChart: Line,
  },
  setup() {
    // Dados fictícios para o gráfico de reservas
    const chartData = reactive({
      labels: ["13 nov", "14 nov", "15 nov"], // Substitua com os dados reais
      datasets: [
        {
          label: 'Reserva Cancelada',
          data: [100, 200, 150], // Substitua com os dados reais
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          fill: true,
        },
        {
          label: 'Ocupação Encerrada',
          data: [50, 150, 100], // Substitua com os dados reais
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          fill: true,
        },
        {
          label: 'Reserva Válida',
          data: [200, 300, 250], // Substitua com os dados reais
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          fill: true,
        },
        {
          label: 'Reserva Expirada',
          data: [150, 250, 200], // Substitua com os dados reais
          backgroundColor: 'rgba(153, 102, 255, 0.2)',
          borderColor: 'rgba(153, 102, 255, 1)',
          fill: true,
        },
      ],
    });

    const chartOptions = reactive({
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      plugins: {
        legend: {
          display: true,
        },
      },
    });

    return { ...toRefs(chartData), ...toRefs(chartOptions) };
  }
});
</script>
