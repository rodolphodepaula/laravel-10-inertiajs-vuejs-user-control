<template>
    <nav
      aria-label="breadcrumb"
      class="bg-white rounded-lg p-2"
    >
      <ol class="flex space-x-1">
        <li
          v-for="(item, index) in items"
          :key="index"
          class="flex items-center"
        >
          <Link
            v-if="index !== items.length - 1"
            :href="item.to"
            class="text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out"
          >
            {{ item.text }}
          </Link>
          <span v-else class="text-gray-500">
            {{ item.text }}
          </span>
          <!-- Separator -->
          <svg
            v-if="index < items.length - 1"
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mx-2 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            />
          </svg>
        </li>
      </ol>
    </nav>
</template>

<script>
import { Link } from "@inertiajs/vue3"


export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
  components: {
    Link
  }
};
</script>

<style scoped>
/* Estilos específicos para o seu breadcrumb */
/* Você pode manter os estilos existentes ou personalizá-los ainda mais aqui */

.breadcrumb {
  /* Estilos básicos */
  padding: 8px 15px;
  margin-bottom: 20px;
  list-style: none;
  background-color: #f5f5f5;
  border-radius: 4px;
}

.breadcrumb-item + .breadcrumb-item::before {
  content: "/";
  padding: 0 5px;
  color: #6c757d;
}

.breadcrumb-item a {
  color: #0275d8;
  text-decoration: none;
}

.breadcrumb-item a:hover {
  text-decoration: underline;
}

.breadcrumb-item.active {
  color: #6c757d;
  pointer-events: none;
  cursor: default;
}
</style>
