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
        $diasSemana = ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
        $turnos = ['MAÑANA', 'TARDE'];
        
        // Horarios de mañana
        $horariosMañana = [
            ['08:00:00', '12:00:00'],
            ['09:00:00', '13:00:00'],
            ['07:00:00', '11:00:00']
        ];
        
        // Horarios de tarde
        $horariosTarde = [
            ['14:00:00', '18:00:00'],
            ['15:00:00', '19:00:00'],
            ['13:00:00', '17:00:00']
        ];

        // Crear horarios para todos los doctores (20 doctores)
        for($i = 1; $i <= 20; $i++) {
            // Cada doctor tendrá entre 3 y 5 días de atención
            $diasAtencion = rand(3, 5);
            $diasSeleccionados = array_rand(array_flip($diasSemana), $diasAtencion);
            
            foreach($diasSeleccionados as $dia) {
                $turno = $turnos[array_rand($turnos)];
                
                if ($turno === 'MAÑANA') {
                    $horario = $horariosMañana[array_rand($horariosMañana)];
                } else {
                    $horario = $horariosTarde[array_rand($horariosTarde)];
                }
                
                Schedule::create([
                    'doctor_id' => $i,
                    'day_of_week' => $dia,
                    'shift' => $turno,
                    'start_time' => $horario[0],
                    'end_time' => $horario[1],
                ]);
            }
        }
    }
}
