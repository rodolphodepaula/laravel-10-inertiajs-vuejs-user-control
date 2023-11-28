<template>
  <div class="project-charts-container">
    <BarChart :chart-data="chartData" :options="chartOptions" with="50" />
    <!-- <total-hours-chart :chart-data="totalHoursData" :options="totalHoursOptions" />
    <reservations-chart :chart-data="reservationsData" :options="reservationsOptions" />
    <usage-chart :chart-data="usageData" :options="usageOptions" /> -->

  </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
import { Bar } from 'vue-chartjs'
import TotalHoursChart from '@/Components/TotalHoursChart.vue';
import ReservationsChart from '@/Components/ReservationsChart.vue';
import UsageChart from '@/Components/UsageChart.vue';
import { defineComponent, reactive } from 'vue'

export default defineComponent({
  components: {
    BarChart: Bar,
    TotalHoursChart,
    ReservationsChart,
    UsageChart
  },
  setup() {
    const chartData = reactive({
      labels: ['Projeto 1', 'Projeto 2', 'Projeto 3'],
      datasets: [
        {
          label: 'Orçamento',
          backgroundColor: '#f87979',
          data: [40, 20, 12]
        }
      ]
    })

    const totalHoursData = reactive({
      labels: ['Total Horas', 'Horas Reservadas', 'Horas Utilizadas'],
      datasets: [
        {
          label: 'Distribuição de Horas',
          data: [16500, 7000, 4000], // Substitua com os dados reais
          backgroundColor: ['#42A5F5', '#66BB6A', '#FFA726'],
        }
      ],
    });

    const totalHoursOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
        },
        title: {
          display: true,
          text: 'Total de Horas'
        }
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Categoria'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Horas'
          }
        }
      }
    };

    const reservationsData = {
      labels: ['13 nov', '14 nov', '15 nov'],
      datasets: [
        {
          label: 'Reserva Cancelada',
          data: [30, 45, 22],
          borderColor: 'rgb(255, 99, 132)',
          backgroundColor: 'rgba(255, 99, 132, 0.5)',
        },
        {
          label: 'Ocupação Encerrada',
          data: [25, 50, 35],
          borderColor: 'rgb(54, 162, 235)',
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
        },
        {
          label: 'Reserva Válida',
          data: [15, 25, 27],
          borderColor: 'rgb(75, 192, 192)',
          backgroundColor: 'rgba(75, 192, 192, 0.5)',
        },
      ],
    };

    const reservationsOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
        },
        title: {
          display: true,
          text: 'Reservas por Situação'
        }
      },
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true,
          title: {
            display: true,
            text: 'Quantidade'
          }
        }
      }
    };


    const usageData = {
      labels: ['Uso de Horas'],
      datasets: [
        {
          label: 'Ociosidade',
          data: [80],
          backgroundColor: 'rgba(255, 99, 132, 0.5)',
        },
        {
          label: 'Horas Utilizadas',
          data: [20],
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
        },
      ],
    };
    const usageOptions = {
      responsive: true,
      maintainAspectRatio: false,
      indexAxis: 'y', // Gráfico de barras horizontal
      plugins: {
        legend: {
          display: true,
        },
        title: {
          display: true,
          text: 'Uso de Horas'
        }
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Porcentagem'
          },
          beginAtZero: true,
        },
        y: {
          title: {
            display: true,
            text: 'Categoria'
          }
        }
      }
    };

    const chartOptions = reactive({
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          type: 'category', // 'category' é um tipo de escala no Chart.js
          // outras opções para o eixo x
        },
        y: {
          type: 'linear', // 'linear' é um tipo de escala no Chart.js
          beginAtZero: true,
          // outras opções para o eixo y
        }
      }
      // outras opções de gráfico
    });

    return {
      totalHoursData,
      totalHoursOptions,
      reservationsData,
      reservationsOptions,
      usageData,
      usageOptions,
      chartData,
      chartOptions
    };
  }
})
</script>
