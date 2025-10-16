<script setup>
import {ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-100">

        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">

                        <div class="flex shrink-0 items-center">

                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800"
                            />

                        </div>

                        <!-- Меню -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink
                                :href="route('services')"
                                :active="route().current('services')"
                            >
                                Сервисы
                            </NavLink>
                        </div>

                    </div>

                    <!-- Кнопка бургер -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Заголовок страницы -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header"/>
            </div>
        </header>

        <!-- Контент -->
        <main class="min-h-[60vh]">
            <slot/>
        </main>

        <footer class="flex flex-col sm:flex-row py-8">
            <div class="w-full sm:w-1/2 text-center">
                Тест задание создал Сергей Бакланов
                <br/>
                <a href="https://nyosru.github.io/2510vue32/task.pdf" target="_blank"
                class="text-blue-600 hover:underline"
                >
                https://nyosru.github.io/2510vue32/task.pdf
                </a>
<br/>
                прочитайте readme:
                <a href="https://github.com/nyosru/2510vue32" target="_blank"
                   class="text-blue-600 hover:underline"
                >https://github.com/nyosru/2510vue32
                </a>
            </div>
            <div class="w-full sm:w-1/2 text-center">
                <div class="flex flex-row items-center justify-center">
                    <div>
                        <a href="https://php-cat.com" class="whitespace-nowrap text-blue-600 hover:underline" target="_blank">
                            <img src="https://php-cat.com/phpcat/cat.png" style="max-height: 60px;" class="inline-block ">
                        </a>
                    </div>
                    <div>
                        Создание сайта<br>
                        <a href="https://php-cat.com" class="whitespace-nowrap text-blue-600 hover:underline" target="_blank"
                           style="color: blue; ">
                            &nbsp;php-cat.com
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
