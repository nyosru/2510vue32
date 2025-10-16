<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import SelectServiceDate from './SelectServiceDate.vue'

defineProps({
    items: {
        type: Array,
        default: () => []
    }
})

</script>

<template>
    <Head title="Сервисы"/>
    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Сервисы
            </h2>
        </template>
            <div>
                <SelectServiceDate :services="items"/>
            </div>
    </AppLayout>

</template>
