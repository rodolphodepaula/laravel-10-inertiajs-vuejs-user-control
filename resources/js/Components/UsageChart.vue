<script>
import { Bar } from 'vue-chartjs';
import { defineComponent, reactive, toRefs } from 'vue';

export default defineComponent({
  components: {
    BarChart: Bar,
  },
  setup() {
    const chartData = reactive({
      labels: ['Ociosidade', 'Horas Utilizadas'], // Substitua com os rótulos desejados
      datasets: [
        {
          label: 'Uso de Horas',
          data: [16656, 0], // Substitua com os dados reais
          backgroundColor: ['#FF6384', '#36A2EB'], // Use as cores desejadas
        },
      ],
    });

    const chartOptions = reactive({
      responsive: true,
      maintainAspectRatio: false,
      indexAxis: 'y', // Gráfico de barra horizontal
      scales: {
        x: {
          beginAtZero: true, // Iniciar escala do eixo X em zero
        }
      },
      plugins: {
        legend: {
          display: false, // Ocultar legenda se desejado
        },
      },
    });

    return { ...toRefs(chartData), ...toRefs(chartOptions) };
  }
});
</script>

<template>
  <div class="usage-chart">
    <bar-chart :chart-data="chartData" :options="chartOptions" />
  </div>
</template>

