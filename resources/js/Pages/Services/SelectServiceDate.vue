<script setup>

import SelectSlot from './SelectSlot.vue'

import { ref, watch, defineProps, defineEmits, computed } from 'vue'

const emit = defineEmits(['selection-changed'])

const props = defineProps({
    services: {
        type: Array,
        required: true,
        default: () => [],
    },
})

const selectedService = ref(null)
const selectedDate = ref('')

// Генерируем массив дат на 7 дней вперёд
const weekDates = computed(() => {
    const dates = []
    const today = new Date()
    for (let i = 0; i < 7; i++) {
        const d = new Date(today)
        d.setDate(today.getDate() + i)
        dates.push(d)
    }
    return dates
})

// Отслеживаем выбор
watch([selectedService, selectedDate], ([service, date]) => {
    if (service && date) {
        emit('selection-changed', { serviceId: service.id, date })
    }
})

// Выбор услуги
const selectService = (service) => {
    selectedService.value = service
    selectedDate.value = '' // сброс даты при смене услуги
}

// Выбор даты
const selectDate = (date) => {
    selectedDate.value = date.toISOString().split('T')[0] // формат YYYY-MM-DD
}

// Формат отображения кнопки даты
const formatDateLabel = (date) => {
    const options = { weekday: 'short', day: 'numeric', month: 'short' }
    return date.toLocaleDateString('ru-RU', options)
}
</script>

<template>
    <div class="p-6 bg-white rounded-2xl shadow-md space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">Выберите услугу и дату</h2>

        <!-- Кнопки выбора услуги -->
        <div class="flex flex-wrap gap-2">
            <button
                v-for="s in props.services"
                :key="s.id"
                @click="selectService(s)"
                class="px-4 py-2 border rounded-lg transition flex items-center gap-2"
                :class="selectedService && selectedService.id === s.id
          ? 'bg-blue-600 text-white border-blue-600'
          : 'bg-gray-100 hover:bg-blue-50 border-gray-300 text-gray-800'"
            >
                {{ s.name }}
                <span
                    :class="' px-2 py-1 rounded '+ ( selectedService && selectedService.id === s.id
          ? 'bg-gray-600 '
          : 'bg-gray-300 ' )"
                >
                    {{ s.duration }} мин
                </span>
            </button>
        </div>

        <!-- Кнопки выбора даты (появляются после выбора услуги) -->
        <div v-if="selectedService" class="mt-4">
            <label class="block mb-2 text-gray-700">Выберите дату</label>
            <div class="flex flex-wrap gap-2">
                <button
                    v-for="date in weekDates"
                    :key="date.toISOString()"
                    @click="selectDate(date)"
                    class="px-3 py-2 border rounded-lg transition"
                    :class="selectedDate === date.toISOString().split('T')[0]
                        ? 'bg-blue-600 text-white border-blue-600'
                        : 'bg-gray-100 hover:bg-blue-50 border-gray-300 text-gray-800'"
                >
                    {{ formatDateLabel(date) }}
                </button>
            </div>
        </div>

        <div v-if="selectedService && selectedDate" class="text-sm text-gray-500 mt-2">
            Длительность услуги: {{ selectedService.duration }} мин<br>
            Вы выбрали: {{ selectedDate }}
        </div>

        <!--            xv-if="selectedServiceId && selectedDate"-->
<!--                    service-id="selectedServiceId"-->
        <div v-if="selectedService && selectedDate" >
            SelectSlot<br/>
        <SelectSlot
            :service-id="selectedService.id"
            :date="selectedDate"
        />
        </div>

    </div>
</template>
