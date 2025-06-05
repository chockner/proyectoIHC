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
        Schema::create('appointments', function (Blueprint $table) { //tabla de citas
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // id del paciente
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // id del doctor
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade'); // id del horario

            $table->date('appointment_date'); // fecha de la cita
            $table->time('appointment_time'); // hora de la cita
            $table->enum('status', ['programada', 'cancelada', 'completada'])->default('programada'); // estado de la cita (programada, cancelada, completada)
            $table->timestamps(0);
            $table->softDeletes(); // opcional, pero útil para eliminar citas sin borrarlas de la base de datos
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['schedule_id']);
        });
        // Eliminar las citas de la base de datos
        Schema::dropIfExists('appointments');
    }
};
