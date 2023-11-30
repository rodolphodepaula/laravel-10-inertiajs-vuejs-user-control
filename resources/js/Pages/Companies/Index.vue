<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import Breadcrumb from '@/Components/Breadcrumb.vue'
import Filter from '@/Components/Filter.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import Table from '@/Components/Table.vue'
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

import { Head, usePage, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { all } from 'axios'

const { companies } = usePage().props
const showOpenModal = ref(false)
const allSelected = ref(false)
const paginator = companies

const formatDate = (data) => {
  const options = {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }

  return new Date(data).toLocaleDateString('pt-BR', options);
}

const breadcrumbItems = [
  { text: 'Dashboard', to: '/' },
  { text: 'Empresas', to: '/companies' }
]
</script>

<template>
  <Head title="Empresas" />
  <authenticated-layout>
    <template #header>
      <breadcrumb :items="breadcrumbItems" />
    </template>
    <div class="flex justify-end bg-gray-100 px-4 py-3 rounded-lg shadow space-x-2">
      <div class="inline-flex space-x-2">
        <!--Botão Adicionar Exportar-->
      </div>
    </div>
    <div class="py-5">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-3 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <div v-if="allSelected" class="flex flex-row p-3 bg-neutral-300">
            <button class="flex items-center btn-link hover:text-red-800 hover:underline">
              <TrashIcon class="w-4 h-4 mr-2" aria-hidden="true" />
              Excluir
            </button>
          </div>
          <Table :paginator="paginator">
            <template #headColumns>
              <THead type="normal" label="Empresa" />
              <THead type="code" label="Código" class="text-center"/>
              <THead type="normal" label="Data Cadastro" class="text-right" />
            </template>
            <template #tableRows>
              <tr v-for="company in companies.data" :key="company.id" class="hover:bg-gray-50">
                <TData type="first" >
                 {{ company.name }}
                </TData>
                <TData type="first" class="text-center">
                 {{ company.code }}
                </TData>
                <TData type="first" class="text-right">
                  {{ formatDate(company.created_at) }}
                </TData>
              </tr>
            </template>

          </Table>
        </div>
      </div>
    </div>
  </authenticated-layout>
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