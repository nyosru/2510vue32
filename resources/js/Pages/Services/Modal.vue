<script setup>
import {useModalStore} from '@/stores/modal'

const modal = useModalStore()
</script>

<template>
    <div v-if="modal.showSuccessModal" class="fixed inset-0 flex items-center justify-center bg-black/50">
        <div class="bg-white p-6 rounded-xl text-center">
            <p>{{ modal.message }}</p>
            <div class="pt-5">
                <button @click="modal.close()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-xl">
                    ОК
                </button>
            </div>
        </div>
    </div>
</template>
