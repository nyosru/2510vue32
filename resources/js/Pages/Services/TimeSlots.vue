<script setup>
import { ref, watch, defineProps } from 'vue'
import { useBookingStore } from '@/stores/bookingStore'

const props = defineProps({
    serviceId: Number,
    date: String,
})

const store = useBookingStore()

const slots = ref([])
const selectedSlot = ref('')
const loading = ref(false)
const error = ref('')

async function loadSlots() {
    if (!props.serviceId || !props.date) return
    loading.value = true
    try {
        const response = await fetch(`/api/free-slots?service_id=${props.serviceId}&date=${props.date}`)
        slots.value = await response.json()
        console.log('✅ Slots reloaded:', slots.value)
    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }
}

// 🔔 слушаем сигнал из Pinia
watch(
    () => store.reloadSignal,
    () => {
        console.log('🔔 reloadSignal изменился!')
        loadSlots()
    },
    { immediate: true }
)
</script>
