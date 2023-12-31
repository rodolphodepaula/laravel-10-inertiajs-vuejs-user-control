<script setup>
import { ref, defineProps, defineEmits, computed, onMounted } from 'vue'
import SelectCompany from '@/Components/Company/SelectCompany.vue'
import ToggleSwitch from '@/Components/ToggleSwitch.vue'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import axios from "axios"

const emit = defineEmits(['close'])
const props = defineProps({
  user: Object,
  companies: Object,
  isEdit: Boolean,
  isShow: Boolean,
})

const model = ref({
  uuid: null,
  name: null,
  email: null,
  enrollment: null,
  status: false,
  password: null,
  password_confirmation: null,
  company_uuid: null,
})

const errors = ref({})
const successMessage = ref('')
const companies = ref(props.companies)

onMounted(() => {
  if (props.user) {
    handleInit()
  }
});

const title = computed(() => {
  return props.isEdit ? 'Editar Usuário' : 'Registro do Usuário'
})

const handleInit = () => {
  model.value.uuid = props.user?.uuid
  model.value.name = props.user?.name
  model.value.email = props.user?.email
  model.value.enrollment = props.user?.enrollment
  model.value.status = props.user?.status ?? false
  model.value.company_uuid = props.user?.company_uuid
}

// Método para fechar o modal
const close = () => {
  emit('close')
}

// Método para salvar o usuário
const saveUser = () => {
  const method = props.isEdit ? 'put' : 'post'
  const url = props.isEdit ? `/api/users/${model.value.uuid}` : '/api/users'

  axios({
    method: method,
    url: url,
    data: model.value,
  })
    .then(response => {
      successMessage.value = 'Usuário salvo com sucesso!';
      setTimeout(() => {
        successMessage.value = '';
        close()
      }, 2000)
    })
    .catch(error => {
      if (error.response && error.response.data && error.response.data.errors) {
        errors.value = error.response.data.errors
      } else {
        console.error('Erro ao salvar usuário:', error)
      }
    })
}

</script>


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
              <h2 class="text-lg font-medium text-gray-900 flex items-left">
                <i class="fas fa-user-pen text-blue-500"></i>
                <span class="pl-3">{{ title }}</span>
              </h2>
            </header>
            <hr class="border-gray-200">
            <div v-if="successMessage" class="bg-green-500 text-white p-4 mb-4">
              {{ successMessage }}
            </div>
            <div class="mt-4 relative flex-1 px-4 sm:px-6 text-left">
              <div class="space-y-4">
                  <input type="hidden" name="uuid" v-model="model.uuid"/>
                  <div class="mb-4">
                    <InputLabel for="name" value="Nome Completo" />
                    <TextInput
                      id="name"
                      type="text"
                      v-model="model.name"
                      required
                      autocomplete="name"
                      class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                      :class="{ 'bg-gray-200': isShow }"
                      :disabled="isShow"
                    />
                    <p v-if="errors.name"><span class="text-red-500 text-sm">{{ errors.name[0] }}</span></p>
                  </div>
                  <div class="mb-4">
                    <InputLabel for="email" value="E-mail" />
                    <TextInput
                      id="email"
                      type="email"
                      v-model="model.email"
                      required
                      autocomplete="email"
                      class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                      :class="{ 'bg-gray-200': isShow }"
                      :disabled="isShow"
                    />
                    <p v-if="errors.email"><span class="text-red-500 text-sm">{{ errors.email[0] }}</span></p>
                  </div>
                  <!-- ... outros campos ... -->
                  <div class="mb-4">
                    <InputLabel for="enrollment" value="Matrícula" />
                    <TextInput
                      id="enrollment"
                      type="text"
                      v-model="model.enrollment"
                      class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                      :class="{ 'bg-gray-200': isShow }"
                      :disabled="isShow"
                      />
                    <p v-if="errors.enrollment"><span class="text-red-500 text-sm">{{ errors.enrollment[0] }}</span></p>
                  </div>
                  <div class="mb-4">
                    <label class="text-gray-700 font-semibold block mb-2">Empresa:</label>
                    <SelectCompany
                      id="company_uuid"
                      :companies="companies"
                      v-model="model.company_uuid"
                      :class="{ 'bg-gray-200': isShow }"
                      :disabled="isShow"
                      />
                    <p v-if="errors.company_uuid"><span class="text-red-500 text-sm">{{ errors.company_uuid[0] }}</span>
                    </p>
                  </div>
                  <div class="mb-4" v-if="!isShow">
                    <InputLabel for="password" value="Senha" />
                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="model.password"
                      autocomplete="new-password" />
                    <p v-if="errors.password"><span class="text-red-500 text-sm">{{ errors.password[0] }}</span></p>
                  </div>
                  <div class="mt-4" v-if="!isShow">
                    <InputLabel for="password_confirmation" value="Confirmar Senha" />
                    <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                      v-model="model.password_confirmation" autocomplete="new-password" />
                  </div>
                  <div class="m-4">
                    <ToggleSwitch
                      v-model="model.status"
                      label="Usuário Ativo"
                      :disabled="isShow"
                      />
                  </div>
                  <hr class="border-gray-200 my-4">
              </div>
            </div>
            <!-- Rodapé fixo -->
          <div class="mt-auto">
            <hr class="border-gray-200">
            <div class="py-4 px-4 sm:px-6 bg-white">
              <div class="flex justify-start space-x-4">
                <button v-if="!isShow" @click="saveUser" type="submit" :disabled="!!successMessage"
                  class="px-4 bg-blue-500 p-3 rounded text-white hover:bg-blue-400">
                  Salvar
                </button>
                <button type="button" :disabled="!!successMessage" @click="close"
                  class="px-4 bg-gray-500 p-3 rounded text-white hover:bg-gray-400">
                  Fechar
                </button>
              </div>
            </div>
          </div>
          <!-- Final do rodapé fixo -->
          </div>
        </div>
      </section>
    </div>
  </div>
</template>