<script setup>
import { defineProps, defineEmits } from 'vue'

const emit = defineEmits(['page'])
const props = defineProps({
  paginator: Object,
});

const goToPage = (page) => {
  emit('page', page)
}
</script>
<template>
  <table class="min-w-full table-auto">
    <thead class="bg-gray-100">
      <tr>
        <slot name="headColumns" />
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <slot name="tableRows" />
    </tbody>
  </table>
  <template v-if="props.paginator">
    <div class="flex items-center justify-between border-t border-gray-200 bg-gray-100 px-4 py-3 sm:px-6">
      <div class="flex flex-1 justify-between sm:hidden">
        <a href="#"
          class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
        <a href="#"
          class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
      </div>
      <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Mostrando
            <span class="font-medium">{{ props.paginator.from }}</span>
            para
            <span class="font-medium">{{ props.paginator.to }}</span>
            de
            <span class="font-medium">{{ props.paginator.total }}</span>
            resultados
          </p>
        </div>
        <div>
          <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <template v-for="(link, index) in props.paginator.links" :key="link.label">
              <a v-if="link.label == index"  @click="goToPage(index)"
                :class="{ 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active }"
                class="relative hidden items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20 md:inline-flex">
              {{ link.label }}
            </a>
            </template>
          </nav>
        </div>
      </div>
    </div>
  </template>
</template>
