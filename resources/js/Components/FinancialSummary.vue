<template>
  <div class="financial-summary">
    <div class="financial-item">
      <h3>Receita Total</h3>
      <p>{{ currency(totalRevenue)}}</p>
    </div>
    <div class="financial-item">
      <h3>Despesas Totais</h3>
      <p>{{ currency(totalExpenses) }}</p>
    </div>
    <div class="financial-item">
      <h3>Lucro Líquido</h3>
      <p>{{ currency(netProfit) }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const totalRevenue = ref(120000); // Valor de exemplo
const totalExpenses = ref(50000); // Valor de exemplo
const netProfit = ref(totalRevenue.value - totalExpenses.value);

// Filtro para formatar os números como moeda
const currency = (value) => {
  return new Intl.NumberFormat('pt-BR', {
    style: 'decimal',
    currency: 'BRL',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(value);
};

</script>

<style scoped>
.financial-summary {
  display: flex;
  justify-content: space-around;
  padding: 1rem;
  background-color: #f3f4f6;
  border-radius: 0.5rem;
}

.financial-item {
  text-align: center;
}

.financial-item h3 {
  color: #374151;
  margin-bottom: 0.5rem;
}

.financial-item p {
  font-size: 1.25rem;
  color: #1f2937;
}
</style>
