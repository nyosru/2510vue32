<script setup>
import { ref, defineProps, defineEmits } from 'vue'
import axios from 'axios'
import { useModalStore } from '@/stores/modal'

const props = defineProps({
    serviceId: {
        type: Number,
        required: true
    },
    date: {
        type: String,
        required: true
    },
    times: {
        type: String,
        required: true
    }
})

const emit = defineEmits(['booked'])

const clientName = ref('')
const clientPhone = ref('')
const message = ref('')

const modal = useModalStore() // ✅ доступ к стору

// Создание бронирования
const bookSlot = async () => {
    if (!clientName.value || !clientPhone.value) {
        message.value = 'Заполните все поля'
        return
    }

    try {
        await axios.post('/api/bookings', {
            service_id: props.serviceId,
            date: props.date,
            times: props.times,
            client_name: clientName.value,
            client_phone: clientPhone.value
        })
        message.value = 'Бронирование успешно создано'
        // уведомляем родителя
        // emit('booked')
        modal.openSuccess('Бронирование успешно создано! ✅')
        // сброс полей
        clientName.value = ''
        clientPhone.value = ''
    } catch (e) {
        console.error(e)
        message.value = 'Ошибка при бронировании'
    }
}
</script>

<template>
    <div class="mt-4 space-y-2 p-4
        max-w-[500px]
        bg-gradient-to-br from-gray-100 to-blue-100 rounded-lg">
        <input
            type="text"
            placeholder="Ваше имя"
            v-model="clientName"
            class="w-full border rounded-lg p-2"
        />
        <input
            type="text"
            placeholder="Телефон"
            v-model="clientPhone"
            class="w-full border rounded-lg p-2"
        />
        <button
            @click="bookSlot"
            class="px-4 py-2 bg-green-600 text-white rounded-lg"
        >
            Забронировать {{ props.times }}
        </button>
        <div v-if="message" class="text-sm text-gray-700 mt-1">{{ message }}</div>
    </div>
</template>
