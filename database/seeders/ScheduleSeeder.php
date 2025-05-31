<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Doctor;


class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i <= 8; $i++) {
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'LUNES',
                'start_time' => sprintf('%02d:00:00', rand(8, 11)), // Horas entre 08:00 y 17:00
                'end_time' => sprintf('%02d:00:00', rand(12, 18)), // Horas entre 09:00 y 18:00
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'MARTES',
                'start_time' => sprintf('%02d:00:00', rand(8, 11)), // Horas entre 08:00 y 17:00
                'end_time' => sprintf('%02d:00:00', rand(12, 18)), // Horas entre 09:00 y 18:00
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'MIERCOLES',
                'start_time' => sprintf('%02d:00:00', rand(8, 11)), // Horas entre 08:00 y 17:00
                'end_time' => sprintf('%02d:00:00', rand(12, 18)), // Horas entre 09:00 y 18:00
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'JUEVES',
                'start_time' => sprintf('%02d:00:00', rand(8, 11)), // Horas entre 08:00 y 17:00
                'end_time' => sprintf('%02d:00:00', rand(12, 18)), // Horas entre 09:00 y 18:00
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'VIERNES',
                'start_time' => sprintf('%02d:00:00', rand(8, 11)), // Horas entre 08:00 y 17:00
                'end_time' => sprintf('%02d:00:00', rand(12, 18)), // Horas entre 09:00 y 18:00
            ]);
        }
    }
}
