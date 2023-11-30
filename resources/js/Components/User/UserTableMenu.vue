<script setup>
import { ref, defineProps, computed , onMounted, defineEmits } from 'vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import UserAction from '@/Components/User/UserAction.vue'
import UserConfirmationModal from '@/Components/User/UserConfirmationModal.vue'
import axios from 'axios';

const emit = defineEmits(['fetchUsers'])
const props = defineProps({
  user: {
    type: Object,
    required: true,
  }
})

const companies = ref({})
const showEditModal = ref(false)
const showViewModal = ref(false)
const showDeleteModalVisible = ref(false)

const shouldShowModal = computed(() => showEditModal.value || showViewModal.value)

const closeModal = () => {
    showEditModal.value = false
    showViewModal.value = false
    emit('fetchUsers')
}

onMounted(() => {
  companies.value = { ...props.user.companies }
})

const openDetailUserModal = () => {
  showEditModal.value = false
  showViewModal.value = ! showViewModal.value
}

const openEditUserModal = () => {
  showViewModal.value = false
  showEditModal.value = ! showEditModal.value
}

const deleteUser = () => {
  showDeleteModalVisible.value = ! showDeleteModalVisible.value
}

const closeDeleteConfirmation = () => {
  showDeleteModalVisible.value = false
}

const confirmDelete = (uuid) => {
  axios.delete(`/api/users/${uuid}`)
    .then(response => {
      console.log('Usuário deletado:', response.data)
      closeDeleteConfirmation()
      emit('fetchUsers')
    })
    .catch(error => {
      console.error('Ocorreu um erro ao deletar o usuário:', error.response)
    })
}


</script>
<template>
  <Menu as="div" class="relative inline-block text-left">
    <MenuButton
      class="inline-flex items-center justify-center w-full p-2 text-sm font-medium text-gray-700 border rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-gray-100">
      <i class="fa fa-ellipsis-vertical"></i>
    </MenuButton>
    <MenuItems
      class="absolute right-0 z-10 mt-2 w-56 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
      <MenuItem>
      <button class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="openDetailUserModal()">
        <i class="fa fa-eye"></i> <span class="pl-3">Ver Detalhes</span>
      </button>
      </MenuItem>
      <MenuItem v-if="!props.user.is_admin">
      <button class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="openEditUserModal()">
        <i class="fa fa-user-pen"></i> <span class="pl-3">Editar Usuário</span>
      </button>
      </MenuItem>
      <MenuItem v-if="!props.user.is_admin">
      <button class="group flex w-full items-center px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
        @click="deleteUser(props.user)">
        <i class="fa fa-trash"></i> <span class="pl-3">Excluir Usuário</span>
      </button>
      </MenuItem>
    </MenuItems>
  </Menu>
  <UserAction
    v-if="shouldShowModal"
    :user="props.user"
    :is-edit="showEditModal"
    :is-show="showViewModal"
    :companies="companies"
    @close="closeModal"
  />
  <UserConfirmationModal
    :isVisible="showDeleteModalVisible"
    :nameUser = props.user.name
    @confirm="confirmDelete(props.user.uuid)"
    @cancel="closeDeleteConfirmation"
  />
</template>