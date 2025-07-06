<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            'Cardiología',
            'Dermatología',
            'Ginecología',
            'Pediatría',
            'Oftalmología',
            'Neurología',
            'Psiquiatría',
            'Traumatología',
            'Ortopedia',
            'Oncología',
            'Endocrinología',
            'Gastroenterología',
            'Neumología',
            'Urología',
            'Otorrinolaringología',
            'Medicina Interna'
        ];
        foreach ($especialidades as $name){
            Specialty::create(['name' => $name,]);
        }
    }
}
