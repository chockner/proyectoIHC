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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario que realizó la acción

            $table->string('action'); // Acción realizada (create, update, delete)
            $table->string('model'); // Modelo afectado (Appointment, Payment, etc.)
            $table->unsignedBigInteger('model_id'); // ID del modelo afectado
            $table->text('changes')->nullable(); // Cambios realizados (JSON o texto)
            $table->string('ip_address')->nullable(); // Dirección IP del usuario
            $table->string('user_agent')->nullable(); // User agent del navegador
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
