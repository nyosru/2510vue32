<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Поездка на квадроцикле', 'duration' => 30],
            ['name' => 'Поездка на квадроцикле', 'duration' => 60],
            ['name' => 'Тур на эндуро', 'duration' => 60],
            ['name' => 'Тур на эндуро', 'duration' => 120],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }

}
