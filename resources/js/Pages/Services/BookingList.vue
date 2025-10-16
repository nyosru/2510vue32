<template>
    <div class="p-4 bg-white rounded-xl shadow">
        <fieldset>
            <legend>Бронирования на {{ formattedDate }}</legend>


        <div v-if="loading" class="text-gray-500">Загрузка...</div>

        <div v-else>
            <div v-if="bookings.length === 0" class="text-gray-400">
                Нет бронирований
            </div>

            <div class="flex flex-col w-full max-w-[400px]">
                <div
                    v-for="booking in bookings"
                    :key="booking.id"
                    class="flex justify-between items-center border-b py-2
                    flex-row"
                >

                    <div class="font-medium">{{ booking.client_name }}</div>
                    <div class="text-sm text-gray-500">{{ booking.time }}</div>
                    <div class="text-sm text-gray-500">{{ booking.end_time }}</div>
                    <div>
                        <button
                            @click="deleteBooking(booking.id)"
                            class="text-red-500 hover:text-red-700 text-xl"
                            title="Удалить"
                        >
                            ✕
                        </button>
                    </div>

                </div>
            </div>
        </div>
        </fieldset>
    </div>
</template>

<script setup>
import {ref, onMounted, computed, watch} from "vue";
import axios from "axios";

const props = defineProps({
    date: {type: String, required: true},
    serviceId: {type: Number, required: true},
});

const bookings = ref([]);
const loading = ref(false);

const formattedDate = computed(() =>
    new Date(props.date).toLocaleDateString("ru-RU")
);

async function loadBookings() {
    loading.value = true;
    try {
        const response = await axios.get("/api/bookings", {
            params: {date: props.date, service_id: props.serviceId},
        });
        bookings.value = response.data;
    } finally {
        loading.value = false;
    }
}

async function deleteBooking(id) {
    if (!confirm("Удалить бронирование?")) return;
    await axios.delete(`/api/bookings/${id}`);
    bookings.value = bookings.value.filter((b) => b.id !== id);
}

onMounted(loadBookings);

// Обновлять, если поменяли дату или услугу
watch([() => props.date, () => props.serviceId], loadBookings);

</script>
