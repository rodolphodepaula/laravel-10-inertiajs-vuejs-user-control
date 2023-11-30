<script>
import { defineComponent } from 'vue'

export default defineComponent({
  props: {
    isVisible: Boolean,
    nameUser: String
  },
  emits: ['confirm', 'cancel'],
  setup(props, { emit }) {
    const cancel = () => {
      emit('cancel')
    }
    const confirm = () => {
      emit('confirm')
    }

    return { cancel, confirm }
  },
})
</script>


<template>
  <div v-if="isVisible" class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg">
      <div>
        <span>Tem certeza que deseja excluir <strong>{{ nameUser }}</strong> ?</span>
      </div>
      <div class="flex justify-end space-x-4 mt-4">
        <button @click="cancel" class="px-4 py-2 rounded text-white bg-gray-500 hover:bg-gray-600">Cancelar</button>
        <button @click="confirm" class="px-4 py-2 rounded text-white bg-red-500 hover:bg-red-600">Confirmar</button>
      </div>
    </div>
  </div>
</template>