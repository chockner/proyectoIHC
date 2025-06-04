<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use App\Models\MedicalRecord;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phoneInicial = 930000000; // Número de teléfono inicial
        for( $i = 1; $i <= 10; $i++) {
            $user = User::create([
                'role_id' => 3, // Asignar el rol de paciente
                'document_id' => str_pad(30000000 + $i, 8, '0', STR_PAD_LEFT), // DNI único
                'password' => Hash::make("paciente{$i}"), // Contraseña por defecto
            ]);
            $phoneInt = $phoneInicial + $i; // Incrementar el número de teléfono
            $phoneString = (string)$phoneInt; // Convertir a string
            Profile::create([
                'user_id' => $user->id,
                'email' => "paciente{$i}@gmail.com",
                'first_name' => "Paciente{$i}",
                'last_name' => 'Gómez',
                'phone' => "{$phoneString}", // Número de teléfono
                'birthdate' => '1992-01-01',
                'address' => 'Av. Administración',
                'gender' => '1', // 0: Hombre, 1: Mujer
                'civil_status' => '0', // 0: Soltero, 1: Casado, 2: Divorciado, 3: Viudo
                'region' => 'Lima',
                'province' => 'Lima',
                'district' => 'San Borja',
                /* 'country' => 'Perú' */
            ]);
            $patient = Patient::create([
                'user_id' => $user->id,
                'blood_type' => 'O+', // Tipo de sangre por defecto
                'allergies' => 'Ninguna', // Alergias por defecto
                'vaccination_received' => 'Ninguna', // Vacunas recibidas por defecto
            ]);
            MedicalRecord::create([
                'patient_id' => $patient->id,
            ]);
        }
    }
}
