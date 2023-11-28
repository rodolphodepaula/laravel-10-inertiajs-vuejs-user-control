<template>
  <select class="form-input flex-1 p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    <option disabled selected>Selecione um perfil</option>
    <option v-for="profile in profiles" :key="profile.id" :value="profile.id">{{ profile.name }}</option>
  </select>
</template>

<script setup>
import { defineProps } from 'vue'

defineProps({
  profiles: Array
})
</script>
