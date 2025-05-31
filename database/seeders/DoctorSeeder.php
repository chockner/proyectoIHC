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
        for ($i = 1; $i <= 8; $i++){
            $user =User::create([
                'role_id' => 2,
                'document_id' => str_pad(20000000 + $i, 8, '0', STR_PAD_LEFT),
                'password' => Hash::make("doctor{$i}"),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'email' => "doctor{$i}@gmail.com",
                'first_name' => "Doctor{$i}",
                'last_name' => 'Pérez',
                'phone' => "92000000{$i}",
                'birthdate' => '1985-01-01',
                'address' => 'Av. Médica',
                'gender' => '0', // 0: Hombre, 1: Mujer
                'civil_status' => '1', // 0: Soltero, 1: Casado, 2: Divorciado, 3: Viudo
                'region' => 'Lima',
                'province' => 'Lima',
                'district' => 'Miraflores',
                /* 'country' => 'Perú' */
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'specialty_id' => $i, // Una especialidad distinta para cada uno
                'license_code' => "LIC00{$i}",
                'experience_years' => rand(5, 25)
            ]);
        }
    }
}
