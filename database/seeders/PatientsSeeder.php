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
        for ($i = 1; $i <= 10; $i++){
            $user = User::create([
                'role_id' => 3, // Paciente
                'document_id' => str_pad(30000000 + $i, 8, '0', STR_PAD_LEFT),
                'password' => Hash::make("paciente{$i}"),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'email' => "paciente{$i}@gmail.com",
                'first_name' => "Paciente{$i}",
                'last_name' => 'García',
                'phone' => "93000000{$i}",
                'birthdate' => '1990-01-01',
                'address' => 'Av. Paciente',
                'gender' => $i % 2 == 0 ? '0' : '1', // Alternar entre hombre y mujer
                'civil_status' => '1', // 0: Soltero, 1: Casado, 2: Divorciado, 3: Viudo
                'region' => 'Lima',
                'province' => 'Lima',
                'district' => 'San Isidro',
                /* 'country' => 'Perú' */
            ]);

            Patient::create([
                'user_id' => $user->id,
                'blood_type' => ['A+', 'B+', 'O+', 'AB+', 'A-', 'B-', 'O-', 'AB-'][($i - 1) % 8],
                'allergies' => $i % 2 == 0 ? 'Ninguna' : 'Penicilina',
                'vaccination_received' => $i % 2 == 0 ? 'COVID-19, Influenza' : 'COVID-19',
            ]);

            MedicalRecord::create([
                'patient_id' => $user->patient->id,
            ]);
        }
    }
}
