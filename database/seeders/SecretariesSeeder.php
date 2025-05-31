<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Secretary;

class SecretariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'role_id' => 4,
                'document_id' => str_pad(40000000 + $i, 8, '0', STR_PAD_LEFT),
                'password' => Hash::make("secretaria{$i}")
            ]);

            Profile::create([
                'user_id' => $user->id,
                'email' => "secretaria{$i}@gmail.com",
                'first_name' => "Secretaria{$i}",
                'last_name' => 'Gómez',
                'phone' => "94000000{$i}",
                'birthdate' => '1992-01-01',
                'address' => 'Av. Administración',
                'gender' => '1', // 0: Hombre, 1: Mujer
                'civil_status' => '0', // 0: Soltero, 1: Casado, 2: Divorciado, 3: Viudo
                'region' => 'Lima',
                'province' => 'Lima',
                'district' => 'San Borja',
                /* 'country' => 'Perú' */
            ]);

            Secretary::create([
                'user_id' => $user->id
            ]);
        }
    }
}
