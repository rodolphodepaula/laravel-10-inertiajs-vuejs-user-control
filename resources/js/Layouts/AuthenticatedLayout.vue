<template>
    <div class="relative min-h-screen flex">
        <div class="bg-neutral-700 text-cyan-100 w-64" :class="`${isMenuOpen ? 'menu-open' : 'menu-close'}`">
            <!-- Logo -->
            <div class="bg-white shadow px-2 py-3 shrink-0 flex items-center">
                <Link :href="route('dashboard')" class="pr-3">
                <application-logo class="block h-7 w-auto fill-current text-gray-800" />
                </Link>
                <button @click="toggleMenu">
                    <i :class="isMenuOpen ? 'fas fa-times' : 'fas fa-bars'" class="text-neutral-700 pl-3"></i>
                </button>
            </div>
            <!-- Itens do Menu-->
            <nav class="pt-3">
                <ul class="menu-lateral">
                    <li v-for="item in menu" :key="item.title">
                        <a :href="item.href" @click="item.submenu && toggleDropdown(item)">
                            <i :class="`menu-item-icon ${item.icon}`" :alt="item.title"></i>
                            <span class="menu-texto"> {{ item.title }} </span>
                            <i v-if="item.isDropdown"
                                :class="item.submenu && item.isDropdownOpen ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"
                                class="chevron pl-3"></i>
                        </a>
                        <ul v-if="item.submenu && item.isDropdownOpen" class="menu-dropdown">
                            <li v-for="subitem in item.submenu" :key="subitem.title">
                                <a :href="subitem.href"><i class="fas fa-check pr-2"></i>{{ subitem.title }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="content min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="p-3">
                    <div class="flex justify-between h-16">
                        <div class="flex menu-top">
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="flex items-center text-gray-800 hover:text-blue-600">
                                    <home-icon class="w-5 h-5 mr-1 text-gray-600"/>
                                    Dashboard
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden auth-top sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            Perfil
                                        </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Sair
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="button-min inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <!-- <ResponsiveNavLink :href="route('users.index')" :active="route().current('users.index')">
                            Usuários
                        </ResponsiveNavLink> -->
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-8x1 mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue"
import { menuData } from '@/menuData'
import ApplicationLogo from "@/Components/ApplicationLogo.vue"
import Dropdown from "@/Components/Dropdown.vue"
import DropdownLink from "@/Components/DropdownLink.vue"
import NavLink from "@/Components/NavLink.vue"
import { HomeIcon, ChartBarIcon } from '@heroicons/vue/24/outline'
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue"
import { Link } from "@inertiajs/vue3"

const showingNavigationDropdown = ref(false)
const isMenuOpen = ref(true)

const menu = ref(menuData)

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value
}

const toggleDropdown = (menuItem) => {
    isMenuOpen.value = true
    menuItem.isDropdownOpen = !menuItem.isDropdownOpen
}


</script>
<style scoped>
.flex {
    display: flex;
    flex-direction: row;
}

.menu {
    /* Defina a largura ou flex-basis do menu lateral, e o flex-shrink como 0 para que ele não encolha */
    flex: 0 0 auto;
}

.content {
    /* Faz com que o conteúdo cresça para ocupar o espaço restante */
    flex-grow: 1;
}

/* Estilos para o menu lateral */
.menu-lateral {
    transition: width 0.3s ease;
    width: 250px;
    background-color: #404040;
    /* Cor de fundo do menu */
    color: white;
    /* Cor do texto */
    min-width: 250px;
    /* Largura mínima */
   /*  height: 100vh; */
    /* Altura total da tela */
}

.menu-open {
    width: 250px;
}

.menu-close {
    width: 60px;
}

.menu-close>div>a {
    display: none;
}

.menu-close .menu-texto,
.menu-close .menu-dropdown,
.menu-close .chevron {
    display: none;
}

.menu-lateral a {
    padding: 10px 15px;
    /* Espaçamento interno */
    text-decoration: none;
    /* Sem sublinhado */
    display: block;
    /* Faz cada link ocupar uma linha inteira */
    color: white;
    /* Cor do texto */
    transition: background-color 0.3s;
    /* Transição suave para hover */
}

.menu-lateral a:hover {
    background-color: #34495e;
    /* Cor de fundo quando passa o mouse */
}

.menu-lateral .menu-item-icon {
    margin-right: 10px;
    /* Espaço entre o ícone e o texto */
}

.menu-dropdown {
    background-color: #525252;
    /*  padding-left: 3rem; */
}

.button-min {
    display: none;
  }

.flex-container {
  display: flex;
  justify-content: space-between;
}

.auth-top {
  margin-left: auto;
}

@media (max-width: 768px) {
  .button-min {
    display: block;
  }
  .menu-top {
    display: none;
  }

  .auth-top {
    display: none;
  }
}

.min-h-screen {
    width: 100%;
    /* Define a largura para 100% da tela */
    margin: 0;
    /* Remove margens */
    padding: 0;
    /* Remove paddings */
}</style>
