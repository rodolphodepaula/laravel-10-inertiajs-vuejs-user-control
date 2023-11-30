<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import Breadcrumb from '@/Components/Breadcrumb.vue'
import Filter from '@/Components/Filter.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import Table from '@/Components/User/UserTable.vue'
import THead from '@/Components/THead.vue'
import TData from '@/Components/TData.vue'
import Checkbox from '@/Components/Checkbox.vue'

import UserCompany from '@/Components/User/UserCompany.vue';
import UserCard from '@/Components/User/UserCard.vue'
import CheckboxItens from '@/Components/Checkbox.vue'
import UserAction from '@/Components/User/UserAction.vue'
import UserTableMenu from '@/Components/User/UserTableMenu.vue'
import SelectCompany from '@/Components/Company/SelectCompany.vue'
import SelectProfile from '@/Components/Profile/SelectProfile.vue'

import { PlusIcon } from '@heroicons/vue/24/outline'
import { CloudArrowDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline'
import { TrashIcon } from '@heroicons/vue/24/outline'

import { Head, router } from '@inertiajs/vue3'
import { ref, onMounted, watch  } from 'vue'
import axios from "axios"


const users = ref([])
const paginator = ref({ current_page: 1 })
const companies = ref({})
const filterOptions = ref({
  name: '',
})

const showOpenModal = ref(false)
const allSelected = ref(false)

onMounted(() => fetchUsers ())

watch(() => users.value, (newUsers) => {
   companies.value = [].concat(...newUsers.map(user => user.companies))
})

const fetchUsers = async (page, params = {}) => {
  paginator.value.current_page = page;
  const requestParams = { ...filterOptions.value, ...params, include: 'companies', page: page }

  await axios.get('/api/users', { params: requestParams })
  .then(response => {
    users.value = response.data.data
    paginator.value = response.data.meta
  }
    )
  .catch(error => console.log(error))
}

const toggleAll = () => {
  users.value.forEach(user => {
    user.selected = allSelected.value
  })
}

const breadcrumbItems = [
  { text: 'Dashboard', to: '/' },
  { text: 'Usuários', to: '/users' }
]

const submit = () => {
  fetchUsers ({ name: filterOptions.value.name })
}

const openEditUserModal = () => {
  showOpenModal.value = !showOpenModal.value
}

const closeEditUserModal = () => {
  showOpenModal.value = false
  fetchUsers()
}

</script>

<template>
  <Head title="Usuários" />
  <authenticated-layout>
    <template #header>
      <breadcrumb :items="breadcrumbItems" />
    </template>
    <div class="flex justify-end bg-gray-100 px-4 py-3 rounded-lg shadow space-x-2">
      <div class="inline-flex space-x-2">
        <button class="flex items-center btn-link hover:text-blue-600 hover:underline" @click="openEditUserModal">
          <PlusIcon class="w-4 h-4 mr-2" aria-hidden="true" />
          Usuário
        </button>
      </div>
    </div>
    <form @submit.prevent="submit">
      <Filter>
        <template #inputFilter>
          <InputLabel for="name" value="Name" />
          <TextInput placeholder="Nome ou Email" id="name" type="text" class="mt-1 block w-full" v-model="filterOptions.name" />
        </template>
        <template #buttonFilter>
          <PrimaryButton :class="{ 'opacity-25': router.processing }" :disabled="router.processing">
            <MagnifyingGlassIcon class="w-4 h-4 mr-2" aria-hidden="true" />
            Buscar
          </PrimaryButton>
        </template>
      </Filter>
    </form>
    <div class="py-5">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-3 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <Table :paginator="paginator" @page="fetchUsers">
            <template #headColumns>
              <THead type="normal" label="Usuários" />
              <THead type="normal" label="Empresa" />
              <THead type="action" label="Ações"/>
            </template>
            <template #tableRows>
              <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                <TData type="first">
                  <user-card :user="user" />
                </TData>
                <TData type="first">
                  <UserCompany :company="user.company" />
                </TData>
                <TData type="first" class="text-center">
                  <UserTableMenu :user="user" @fetchUsers="fetchUsers()" />
                </TData>
              </tr>
              <tr v-if="users.length === 0">
                <td colspan="4" class="flex items-center m-4">
                  Nenhum Registro encontrado!
                </td>
              </tr>
            </template>
          </Table>
        </div>
      </div>
    </div>
  </authenticated-layout>
  <user-action
    v-if="showOpenModal"
    @close="showOpenModal = false"
    :companies="companies"
  />
</template>

<style>
.btn-link {
  padding: 6px 12px;
  border: none;
  background: none;
  color: #51545b;
  /* Esta é uma cor genérica de exemplo, substitua pela cor do seu logo */
  cursor: pointer;
  transition: color 0.3s, text-decoration 0.3s;
  font-weight: bold;
}

.btn-link:hover {
  text-decoration: underline;
}
</style>