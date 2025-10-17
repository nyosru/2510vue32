import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useBookingStore = defineStore('bookingStore', () => {
    const reloadSignal = ref(0)

    function triggerReload() {
        console.log('🔄 triggerReload called')
        reloadSignal.value++
    }

    return { reloadSignal, triggerReload }
})
