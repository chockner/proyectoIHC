<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\User;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunas citas existentes
        $appointments = Appointment::take(10)->get();
        $users = User::where('role_id', 1)->take(5)->get(); // Pacientes
        $admins = User::where('role_id', 3)->take(2)->get(); // Administradores

        if ($appointments->isEmpty()) {
            $this->command->info('No hay citas disponibles para crear pagos de ejemplo.');
            return;
        }

        $paymentMethods = ['tarjeta', 'transferencia', 'yape', 'plin', 'clinica'];
        $statuses = ['pendiente', 'validado', 'rechazado'];

        foreach ($appointments as $index => $appointment) {
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $status = $statuses[array_rand($statuses)];
            
            $payment = Payment::create([
                'appointment_id' => $appointment->id,
                'uploaded_by' => $users->random()->id,
                'validated_by' => $status === 'validado' ? $admins->random()->id : null,
                'image_path' => $paymentMethod !== 'tarjeta' && $paymentMethod !== 'clinica' ? 'comprobantes/ejemplo_' . ($index + 1) . '.jpg' : null,
                'payment_method' => $paymentMethod,
                'amount' => $appointment->specialty->cost ?? 150.00,
                'status' => $status,
                'uploaded_at' => now()->subDays(rand(1, 30)),
                'validated_at' => $status === 'validado' ? now()->subDays(rand(1, 15)) : null,
            ]);

            // Si el pago está validado, mantener la cita como programada (no cambiar a confirmada)
            // Las citas se mantienen como 'programada' hasta que se completen
            if ($status === 'validado') {
                // No cambiar el status de la cita, mantener como 'programada'
                // Solo actualizar si es necesario algún otro campo
            }
        }

        $this->command->info('Pagos de ejemplo creados exitosamente.');
    }
} 