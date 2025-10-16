<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import SelectServiceDate from './SelectServiceDate.vue'

import {ref} from "vue";

defineProps({
    items: {
        type: Array,
        default: () => []
    }
})

const showSuccessModal = ref(false)

const onBooked = async () => {
    // selectedSlot.value = null
    // await loadSlots()
    showSuccessModal.value = true
}

const closeModal = async () => {
    showSuccessModal.value = false
}



</script>

<template>

    <Head title="Сервисы"/>

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Сервисы
            </h2>
        </template>

<!--        <div class="flex flex-row md:flex-col">-->
<!--            <div class="py-12">-->
<!--                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">-->
<!--                    <ul v-if="items.length">-->
<!--                        <li v-for="i in items" :key="i.id">-->
<!--                            {{ i.name }} — {{ i.duration }}-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <p v-else>нет данных</p>-->
<!--                </div>-->
<!--            </div>-->
            <div>
                SelectServiceDate<br/>
                <SelectServiceDate :services="items"/>



            </div>
<!--        </div>-->
    </AppLayout>

</template>
