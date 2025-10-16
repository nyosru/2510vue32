// resources/js/stores/modal.js
import { defineStore } from 'pinia'

export const useModalStore = defineStore('modal', {
    state: () => ({
        showSuccessModal: false,
        message: ''
    }),
    actions: {
        openSuccess(message = 'Успешно!') {
            this.message = message
            this.showSuccessModal = true
        },
        close() {
            this.showSuccessModal = false
            this.message = ''
        }
    }
})
