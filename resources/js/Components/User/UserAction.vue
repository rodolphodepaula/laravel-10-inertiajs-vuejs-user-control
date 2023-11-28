<template>
  <div class="fixed inset-0 overflow-hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 overflow-hidden">
      <!-- Fundo escurecido -->
      <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
        <!-- Container do modal lateral -->
        <div class="w-screen max-w-md">
          <!-- Conteúdo do modal -->
          <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
            <header class="px-4 sm:px-6 bg-blue-100 py-4">
              <h2 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-user-pen text-blue-500"></i>
                <span class="pl-3">{{ title }}</span>
              </h2>
            </header>
            <hr class="border-gray-200">
            <div class="mt-4 relative flex-1 px-4 sm:px-6">
              <div class="space-y-4">
                <form @submit.prevent="saveUser">
                  <div class="flex flex-col items-center mb-4">
                    <div class="flex flex-col items-center">
                      <img v-if="previewImage" :src="previewImage" alt="Preview"
                        class="mb-4 h-32 w-32 rounded-full object-cover bg-gray-100 border-2 border-gray-300">
                      <span v-else
                        class="mb-4 h-32 w-32 rounded-full flex items-center justify-center bg-gray-100 border-2 border-gray-300 text-gray-500">Sem
                        Foto</span>
                    </div>
                    <input type="file" @change="handleImageChange" class="hidden" ref="photoInput">
                    <button type="button" @click="triggerFileInput"
                      class="mt-2 px-4 bg-blue-500 p-2 rounded text-white hover:bg-blue-400">Upload Foto</button>
                  </div>
                  <div class="mb-4">
                    <label class="text-gray-700 font-semibold block mb-2">Nome Completo:</label>
                    <input type="text" v-model="model.name"
                      class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                  </div>
                  <div class="mb-4">
                    <label class="text-gray-700 font-semibold block mb-2">E-mail:</label>
                    <input type="email" v-model="model.email"
                      class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                  </div>
                  <!-- ... outros campos ... -->
                  <div class="mb-4">
                    <label class="text-gray-700 font-semibold block mb-2">Matrícula:</label>
                    <input type="text" v-model="model.enrollment"
                      class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                  </div>
                  <!-- ... outros campos ... -->
                  <!-- <div class="mb-4">
                    <label class="text-gray-700 font-semibold block mb-2">Tipo de Autenticação:</label>
                    <select v-model="model.source"
                      class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                      <option>SSO</option>
                      <option>Usuário e Senha</option>
                    </select>
                  </div> -->
                  <!-- ... outros campos ... -->
                  <!-- <div class="mb-4">
                    <label class="text-gray-700 font-semibold block mb-2">Perfil:</label>
                    <select v-model="model.profile"
                      class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                      <option>Manager</option>
                    </select>
                  </div> -->
                  <div class="mb-4">
                    <ToggleSwitch v-model="model.status" label="Usuário Ativo" />
                  </div>
                  <hr class="border-gray-200 my-4">
                  <div class="mt-auto py-4 px-4 sm:px-6">
                    <div class="flex justify-start space-x-4">
                      <button type="submit" class="px-4 bg-blue-500 p-3 rounded text-white hover:bg-blue-400">
                        Salvar
                      </button>
                      <button type="button" @click="closeModal"
                        class="px-4 bg-gray-500 p-3 rounded text-white hover:bg-gray-400">
                        Fechar
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, computed } from 'vue'
import ToggleSwitch from '@/Components/ToggleSwitch.vue'
import { router } from '@inertiajs/vue3'


// Propriedades e eventos do componente
const props = defineProps({
  user: Object,
  isEdit: Boolean,
})

const model = ref({})
const emit = defineEmits(['close'])

const title = computed(() => {
  return props.isEdit ? 'Editar Usuário' : 'Adicionar Usuário'
})

/* const handleInit = () => {
  props.isEdit.value = !!props.user
  model.value = props.user
} */



// Método para fechar o modal
const closeModal = () => {
  emit('close')
}

// Método para salvar o usuário
const saveUser = () => {
  const method = props.isEdit ? 'put' : 'post'
  const url = props.isEdit ? `/users/${model.uuid}` : '/users'

  const data = {
    name: model.value.name,
    email: model.value.email,
    enrollment: model.value.enrollment,
    status: model.value.status,
  }

  router.visit(url, {
    method: method,
    data: data,
  })

  closeModal()
}
</script>
