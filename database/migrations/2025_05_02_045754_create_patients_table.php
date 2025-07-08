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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('blood_type', 3)->nullable();
            $table->text('allergies')->nullable();
            $table->text('vaccination_received')->nullable();
            $table->string('emergency_contact', 100)->nullable();
            $table->string('emergency_phone', 15)->nullable();
            $table->timestamps(0);
            $table->softDeletes(); // opcional, pero útil para eliminar pacientes sin borrarlos de la base de datos
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::dropIfExists('patients');
    }
};
