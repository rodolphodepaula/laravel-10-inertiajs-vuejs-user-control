<script setup>
import { computed } from 'vue'
import { defineProps } from 'vue'

const props = defineProps({
  user: {
    type: Object,
    required: true,
  }
});

const userInitials = computed(() => {
  return props.user.name
    .split(' ')
    .map((n) => n[0])
    .join('')
});
</script>

<template>
  <div class="flex items-center space-x-2 p-2 rounded-lg ">
    <div class="flex-shrink-0">
      <span class="block h-2 w-2 rounded-full bg-blue-600" v-if="user.status"></span>
      <span class="block h-2 w-2 rounded-full bg-gray-600" v-else></span>
    </div>
    <div class="flex-shrink-0">
      <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
        <span v-if="!user.photo">{{ userInitials }}</span>
        <img v-else :src="user.photo" alt="User photo" class="rounded-full" />
      </div>
    </div>
    <div class="flex-grow">
      <div class="text-sm font-medium">{{ user.name }}</div>
      <div class="text-xs text-gray-600">{{ user.email }}</div>
      <div class="text-xs text-gray-500">Matricula: {{ user.enrollment }}</div>
    </div>
  </div>
</template>