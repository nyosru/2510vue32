<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import ServiceBookingForm from './ServiceBookingForm.vue'

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

        <div class="flex flex-row md:flex-col">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <ul v-if="items.length">
                        <li v-for="i in items" :key="i.id">
                            {{ i.name }} — {{ i.duration }}
                        </li>
                    </ul>
                    <p v-else>нет данных</p>
                </div>
            </div>
            <div>
                <ServiceBookingForm :services="items"/>
            </div>
        </div>
    </AppLayout>

</template>
