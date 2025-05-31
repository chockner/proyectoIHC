<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'role_id' => 1,
            /* 'email' => 'admin@gmail.com', */
            'document_id' => '00000000', // DNI como identificador único
            'password' => Hash::make('admin123'),
        ]);
        Profile::create([
            'user_id' => $adminUser->id,
            'email' => 'admin@gmail.com',
            'first_name' => 'Admin',
            'last_name' => 'Principal',
            'phone' => '900000001',
            'birthdate' => '1990-01-01',
            'address' => 'Oficina central',
            'gender' => '0', // 0: Hombre, 1: Mujer
            'civil_status' => '0', // 0: Soltero, 1: Casado, 2: Divorciado, 3: Viudo
            'region' => 'Lima',
            'province' => 'Lima',
            'district' => 'Lima',
            /* 'country' => 'Perú', */
        ]);
    }
}
