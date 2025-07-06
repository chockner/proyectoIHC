<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres = [
            'Dr. Carlos', 'Dra. María', 'Dr. Roberto', 'Dra. Ana', 'Dr. Luis',
            'Dra. Carmen', 'Dr. Javier', 'Dra. Patricia', 'Dr. Miguel', 'Dra. Elena',
            'Dr. Fernando', 'Dra. Isabel', 'Dr. Antonio', 'Dra. Rosa', 'Dr. Manuel',
            'Dra. Lucía', 'Dr. Pedro', 'Dra. Teresa', 'Dr. Francisco', 'Dra. Gloria'
        ];

        $apellidos = [
            'García', 'Rodríguez', 'López', 'Martínez', 'González',
            'Pérez', 'Sánchez', 'Ramírez', 'Torres', 'Flores',
            'Rivera', 'Morales', 'Castro', 'Ortiz', 'Silva',
            'Cruz', 'Reyes', 'Moreno', 'Jiménez', 'Díaz'
        ];

        $distritos = [
            'Miraflores', 'San Isidro', 'Barranco', 'Surco', 'La Molina',
            'San Borja', 'Lince', 'Jesús María', 'Magdalena', 'Pueblo Libre'
        ];

        // Crear 20 doctores (uno para cada especialidad + extras)
        for ($i = 1; $i <= 20; $i++) {
            $nombreIndex = ($i - 1) % count($nombres);
            $apellidoIndex = ($i - 1) % count($apellidos);
            $distritoIndex = ($i - 1) % count($distritos);
            
            $user = User::create([
                'role_id' => 2, // Doctor
                'document_id' => str_pad(20000000 + $i, 8, '0', STR_PAD_LEFT),
                'password' => Hash::make("doctor{$i}"),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'email' => "doctor{$i}@gmail.com",
                'first_name' => $nombres[$nombreIndex],
                'last_name' => $apellidos[$apellidoIndex],
                'phone' => "92000000{$i}",
                'birthdate' => '198' . rand(0, 9) . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'address' => 'Av. Médica ' . $i,
                'gender' => $i % 2 == 0 ? '0' : '1', // Alternar entre hombre y mujer
                'civil_status' => rand(0, 3), // 0: Soltero, 1: Casado, 2: Divorciado, 3: Viudo
                'region' => 'Lima',
                'province' => 'Lima',
                'district' => $distritos[$distritoIndex],
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'specialty_id' => ($i <= 16) ? $i : rand(1, 16), // Los primeros 16 tienen especialidades únicas, los demás aleatorias
                'license_code' => "LIC" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'experience_years' => rand(3, 30)
            ]);
        }
    }
}
