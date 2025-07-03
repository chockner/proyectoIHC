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
                'shift' => 'MAÑANA', // Turno de la mañana
                'start_time' => '08:00:00', // Hora de inicio
                'end_time' => '13:00:00', // Hora de fin
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'MARTES',
                'shift' => 'TARDE', // Turno de la tarde
                'start_time' => '14:00:00', // Hora de inicio
                'end_time' => '19:00:00', // Hora de fin
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'MIERCOLES',
                'shift' => 'MAÑANA', // Turno de la mañana
                'start_time' => '08:00:00', // Hora de inicio
                'end_time' => '13:00:00', // Hora de fin
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'JUEVES',
                'shift' => 'TARDE', // Turno de la tarde
                'start_time' => '14:00:00', // Hora de inicio
                'end_time' => '19:00:00', // Hora de fin
            ]);
            Schedule::create([
                'doctor_id' => $i,
                'day_of_week' => 'VIERNES',
                'shift' => 'MAÑANA', // Turno de la mañana
                'start_time' => '08:00:00', // Hora de inicio
                'end_time' => '13:00:00', // Hora de fin
            ]);
        }
    }
}
