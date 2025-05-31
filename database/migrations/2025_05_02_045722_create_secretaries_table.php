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
        Schema::create('secretaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps(0);
            $table->softDeletes(); // opcional, pero útil para eliminar secretarios sin borrarlos de la base de datos
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secretaries', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            //$table->dropForeign(['specialty_id']);
        });

        Schema::dropIfExists('secretaries');
    }
};
