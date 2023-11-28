<template>
  <div class="total-hours-chart">
    <bar-chart :chart-data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs';
import { defineComponent, reactive, toRefs } from 'vue';

export default defineComponent({
  name: 'TotalHoursChart',
  components: {
    BarChart: Bar,
  },
  setup() {
    const chartData = reactive({
      labels: ['Total Horas', 'Horas Reservadas', 'Horas Utilizadas'],
      datasets: [
        {
          label: 'Horas',
          data: [16500, 7000, 4000], // Substitua com os dados reais
          backgroundColor: ['#42A5F5', '#66BB6A', '#FFA726'],
        }
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
        title: {
          display: true,
          text: 'Distribuição Total de Horas'
        }
      },
    });

    return { ...toRefs(chartData), ...toRefs(chartOptions) };
  }
});
</script>

<style scoped>
.total-hours-chart {
  /* Estilizações específicas para o componente, se necessário */
}
</style>
