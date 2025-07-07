<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); // Usuario que subió el comprobante de pago
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('cascade'); // Usuario que validó el pago

            $table->string('image_path')->nullable(); // Ruta de la imagen del comprobante de pago
            $table->string('payment_method'); // Método de pago (yape, plin, etc.)
            $table->decimal('amount', 8, 2); // Monto del pago
            $table->enum('status', ['pendiente', 'validado', 'rechazado'])->default('pendiente'); // Estado del pago (pendiente, validado, rechazado)
            $table->datetime('uploaded_at')->nullable(); // Fecha y hora de subida del comprobante de pago
            $table->dateTime('validated_at')->nullable(); // Fecha y hora de validación del pago
            
            $table->timestamps(0);
            $table->softDeletes(); // opcional, pero útil para eliminar pagos sin borrarlos de la base de datos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropForeign(['uploaded_by']);
            $table->dropForeign(['validated_by']);
        });
        Schema::dropIfExists('payments');
    }
};
