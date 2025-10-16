<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = \App\Models\Booking::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Берём случайную услугу
        $service = Service::inRandomOrder()->first();

        return [
            'service_id' => $service->id,
            'date' => $this->faker->dateTimeBetween('2025-10-16', '2025-10-20')->format('Y-m-d'),
            'time' => $this->faker->randomElement([
                '10:00', '11:00', '11:30', '13:00', '14:00', '16:00', '18:00', '18:30'
            ]),
            'client_name' => $this->faker->name,
            'client_phone' => $this->faker->numerify('+7000000000'),
        ];
    }
}
