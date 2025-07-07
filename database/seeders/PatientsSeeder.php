<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Patient;
use App\Models\MedicalRecord;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres = [
            'Juan', 'María', 'Carlos', 'Ana', 'Luis', 'Carmen', 'Javier', 'Patricia',
            'Miguel', 'Elena', 'Fernando', 'Isabel', 'Antonio', 'Rosa', 'Manuel',
            'Lucía', 'Pedro', 'Teresa', 'Francisco', 'Gloria', 'Roberto', 'Sofia',
            'Diego', 'Valeria', 'Ricardo', 'Natalia', 'Alberto', 'Camila', 'Eduardo', 'Daniela'
        ];

        $apellidos = [
            'García', 'Rodríguez', 'López', 'Martínez', 'González', 'Pérez', 'Sánchez',
            'Ramírez', 'Torres', 'Flores', 'Rivera', 'Morales', 'Castro', 'Ortiz',
            'Silva', 'Cruz', 'Reyes', 'Moreno', 'Jiménez', 'Díaz', 'Vargas',
            'Herrera', 'Romero', 'Alvarez', 'Mendoza', 'Ruiz', 'Delgado', 'Vega', 'Rojas', 'Medina'
        ];

        $distritos = [
            'Miraflores', 'San Isidro', 'Barranco', 'Surco', 'La Molina', 'San Borja',
            'Lince', 'Jesús María', 'Magdalena', 'Pueblo Libre', 'Breña', 'Rímac',
            'Los Olivos', 'Comas', 'Independencia', 'San Martín de Porres'
        ];

        $alergias = [
            'Ninguna', 'Penicilina', 'Polen', 'Ácaros', 'Mariscos', 'Lácteos',
            'Gluten', 'Huevos', 'Frutos secos', 'Sulfitos'
        ];

        $vacunas = [
            'COVID-19', 'COVID-19, Influenza', 'COVID-19, Influenza, Hepatitis B',
            'COVID-19, Triple Viral', 'COVID-19, Influenza, Neumococo'
        ];

        for ($i = 1; $i <= 30; $i++){
            $nombreIndex = ($i - 1) % count($nombres);
            $apellidoIndex = ($i - 1) % count($apellidos);
            $distritoIndex = ($i - 1) % count($distritos);
            
            $user = User::create([
                'role_id' => 3, // Paciente
                'document_id' => str_pad(30000000 + $i, 8, '0', STR_PAD_LEFT),
                'password' => Hash::make("paciente{$i}"),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'email' => "paciente{$i}@gmail.com",
                'first_name' => $nombres[$nombreIndex],
                'last_name' => $apellidos[$apellidoIndex],
                'phone' => "93000000{$i}",
                'birthdate' => '19' . rand(70, 99) . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'address' => 'Av. Paciente ' . $i,
                'gender' => $i % 2 == 0 ? '0' : '1', // Alternar entre hombre y mujer
                'civil_status' => rand(0, 3), // 0: Soltero, 1: Casado, 2: Divorciado, 3: Viudo
                'region' => 'Lima',
                'province' => 'Lima',
                'district' => $distritos[$distritoIndex],
            ]);

            Patient::create([
                'user_id' => $user->id,
                'blood_type' => ['A+', 'B+', 'O+', 'AB+', 'A-', 'B-', 'O-', 'AB-'][($i - 1) % 8],
                'allergies' => $alergias[array_rand($alergias)],
                'vaccination_received' => $vacunas[array_rand($vacunas)],
            ]);

            MedicalRecord::create([
                'patient_id' => $user->patient->id,
            ]);
        }
    }
}
