<script setup>
import {ref, watch} from 'vue'
import axios from 'axios'
import BookingForm from './BookingForm.vue'

// Объявляем входящие пропсы
const props = defineProps({
    serviceId: {
        type: Number,
        required: true
    },
    date: {
        type: String,
        required: true
    }
})

const slots = ref([])
const selectedSlot = ref(null)
const loading = ref(false)

// Загрузка доступных слотов
const loadSlots = async () => {
    if (!props.serviceId || !props.date) return
    loading.value = true
    try {
        const res = await axios.get('/api/slots', {
            params: {service_id: props.serviceId, date: props.date}
        })
        slots.value = res.data
    } catch (e) {
        console.error(e)
        slots.value = []
    } finally {
        loading.value = false
    }
}

// Перезапуск при изменении props
watch([() => props.serviceId, () => props.date], loadSlots, {immediate: true})

// Функция выбора слота
const selectSlot = (slot) => {
    selectedSlot.value = slot
}

// const onBooked = async () => {
//     selectedSlot.value = null
//     await loadSlots()
//     emit('booked')
// }


</script>


<template>
    <div class="p-4 bg-white rounded-2xl shadow-md mt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Доступные слоты</h3>

        <div v-if="loading" class="text-gray-500">Загрузка...</div>
        <div v-else-if="error" class="text-red-500">{{ error }}</div>
        <div v-else-if="slots.length === 0" class="text-gray-500">Нет доступных слотов</div>
        <div v-else class="flex flex-wrap gap-2">
            <!--                @click="selectSlot(slot)"-->
            <button
                v-for="slot in slots"
                :key="slot.time"
                @click="selectSlot(slot.time)"
                class="px-3 py-2 border rounded-lg transition"
                :class="selectedSlot === slot.time
                    ? 'bg-blue-600 text-white border-blue-600'
                    : 'bg-gray-100 hover:bg-blue-50 border-gray-300 text-gray-800'"
            >
                {{ slot.time }}
            </button>
        </div>

        <div v-if="selectedSlot" class="mt-2 text-sm text-gray-500">
            Вы выбрали: {{ selectedSlot }}
            <!--                :slot="selectedSlot"-->

            <BookingForm
                :service-id="props.serviceId"
                :date="props.date"
                :times="selectedSlot"
                @booked="onBooked"
            />

        </div>




    </div>
</template>
