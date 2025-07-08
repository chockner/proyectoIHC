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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('specialty_id')->constrained('specialties')->onDelete('cascade');

            $table->string('license_code', 6)->unique();
            $table->integer('experience_years')->default(0);
            $table->text('professional_bio')->nullable();
            $table->timestamps(0);
            $table->softDeletes(); // opcional, pero útil para eliminar doctores sin borrarlos de la base de datos
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['specialty_id']);
        });
        
        Schema::dropIfExists('doctors');
    }

};
