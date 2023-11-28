<template>
  <Menu as="div" class="relative inline-block text-left">
    <MenuButton
      class="inline-flex items-center justify-center w-full p-2 text-sm font-medium text-gray-700 border rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-gray-100">
      <i class="fa fa-ellipsis-vertical"></i>
    </MenuButton>
    <MenuItems
      class="absolute right-0 z-10 mt-2 w-56 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
      <MenuItem>
      <button class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="openEditUserModal">
        <i class="fa fa-user-group"></i> <span class="pl-3"> </span>
      </button>
      </MenuItem>
      <MenuItem>
      <button class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="openEditUserModal">
        <i class="fa fa-user-pen"></i> <span class="pl-3">Editar Usuário</span>
      </button>
      </MenuItem>
      <MenuItem>
      <button class="group flex w-full items-center px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
        @click="deleteUser">
        <i class="fa fa-trash"></i> <span class="pl-3">Excluir Usuário</span>
      </button>
      </MenuItem>
      <!-- ... outros itens do menu ... -->
    </MenuItems>
  </Menu>
  <UserAction v-if="showEditModal" :user="selectedUser" :is-edit="true" @close="showEditModal = false" />
</template>

<script setup>
import { ref } from 'vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import UserAction from '@/Components/User/UserAction.vue'

const selectedUser = ref({})
const showEditModal = ref(false)


const doSomething = () => {

}

const openEditUserModal = (user) => {
  console.log(showEditModal.value)
  selectedUser.value = user
  showEditModal.value = ! showEditModal.value
};

const deleteUser = () => {

}
</script>
