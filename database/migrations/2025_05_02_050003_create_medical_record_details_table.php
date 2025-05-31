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
        Schema::create('medical_record_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained('medical_records')->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');

            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable(); //tratamiento
            $table->text('notes')->nullable(); //notas
            $table->timestamps(0);
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_record_details', function (Blueprint $table) {
            $table->dropForeign(['medical_record_id']);
            $table->dropForeign(['appointment_id']);
        });
        Schema::dropIfExists('medical_record_details');
    }
};
