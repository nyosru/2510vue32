<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Данные для конкретных бронирований
        $bookings = [
            ['service_id' => 1, 'times' => ['10:00', '11:00', '13:00', '18:00']],
            ['service_id' => 2, 'times' => ['10:00']],
            ['service_id' => 3, 'times' => ['10:00', '11:30', '18:30']],
            ['service_id' => 4, 'times' => ['14:00']],
        ];

        // Получаем сегодняшнюю дату
        $startDate = now()->startOfDay();

        // Добавляем 3 дня вперёд
        for ($i = 0; $i < 4; $i++) {
            $currentDate = clone $startDate;
            $currentDate->addDays($i);

            foreach ($bookings as $b) {

                $service = Service::find($b['service_id']);
                if (!$service) continue;

                foreach ($b['times'] as $time) {

                    $dateTimeStr = $currentDate->format('Y-m-d') . ' ' . $time;
                    $startTime = Carbon::parse($dateTimeStr);

                    $endTime = $startTime->copy()
                        ->addMinutes($service->duration + 29);

                    Booking::factory()->create([
                        'service_id' => $b['service_id'],
                        'date' => $currentDate->toDateString(),
                        'time' => $time,
                        'end_time' => $endTime->format('H:i'), // Форматируем время
                    ]);
                }
            }
        }
    }
}
