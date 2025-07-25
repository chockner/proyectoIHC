<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            SpecialtiesSeeder::class,
            AdminSeeder::class,
            DoctorSeeder::class,
            ScheduleSeeder::class,
            SecretariesSeeder::class,
            PatientsSeeder::class,
            AppointmentsSeeder::class,
            // Otros seeders...
        ]);
    }
}
