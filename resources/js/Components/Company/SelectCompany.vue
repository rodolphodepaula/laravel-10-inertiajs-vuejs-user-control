<script>
export default {
  name: 'SelectCompany',
  props: {
    modelValue: {
      type: Boolean,
      default: false,
    },
    companies: {
      type: Object,
      default: {},
    },
  },
  emits: ['update:modelValue'],
  computed: {
    selectedCompany: {
      get() {
        return this.modelValue
      },
      set(newValue) {
        this.$emit('update:modelValue', newValue)
      },
    },
  },
}
</script>
<template>
  <select
    class="form-input flex-1 p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    v-model="selectedCompany"
  >
    <option disabled selected>Selecione uma empresa</option>
    <option v-for="company in companies" :key="company.uuid" :value="company.uuid">{{ company.name }}</option>
  </select>
</template>
