<script setup>
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    tasks: {
        type: Array,
        default: () => []
    }
})
</script>

<template>

    <Head title="Задачи" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Задачи
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <ul v-if="tasks.length">
                    <li v-for="task in tasks" :key="task.id">
                        {{ task.title }} — {{ task.status }}
                    </li>
                </ul>
                <p v-else>Задач нет</p>
            </div>
        </div>
    </AppLayout>
</template>
