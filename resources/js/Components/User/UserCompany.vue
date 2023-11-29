<script setup>
import { defineProps } from 'vue'

const props = defineProps(['company'])
</script>


<template>
  <div v-if="props.company" class="flex gap-2">
    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full" :alt="props.company">
      {{ props.company }}
    </span>
  </div>
</template>