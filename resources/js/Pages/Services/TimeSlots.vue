<script setup>
import { ref, watch, defineProps } from 'vue'

const props = defineProps({
    serviceId: Number,
    date: String,
})

const slots = ref([])
const selectedSlot = ref('')
const loading = ref(false)
const error = ref('')

watch(
    () => [props.serviceId, props.date],
    async ([serviceId, date]) => {
        if (!serviceId || !date) return
        loading.value = true
        error.value = ''
        try {
            const response = await fetch(`/api/free-slots?service_id=${serviceId}&date=${date}`)
            if (!response.ok) throw new Error('Ошибка загрузки слотов')
            slots.value = await response.json()
        } catch (e) {
            error.value = e.message
        } finally {
            loading.value = false
        }
    },
    { immediate: true }
)
</script>

<template>
    <div class="p-6 bg-white rounded-2xl shadow-md space-y-4">
        <h2 class="text-xl font-semibold">Выберите время</h2>

        <div v-if="loading" class="text-gray-500">Загрузка доступных слотов...</div>
        <div v-else-if="error" class="text-red-500">{{ error }}</div>

        <div v-else>
            <div v-if="slots.length === 0" class="text-gray-500">
                Нет доступных слотов на выбранную дату.
            </div>

            <div v-else class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <button
                    v-for="slot in slots"
                    :key="slot.id"
                    @click="selectedSlot = slot.time"
                    :class="[
            'p-2 rounded-xl border transition',
            selectedSlot === slot.time
              ? 'bg-blue-600 text-white border-blue-600'
              : 'bg-white text-gray-700 hover:bg-gray-100'
          ]"
                >
                    {{ slot.time }}
                </button>
            </div>
        </div>
    </div>
</template>
