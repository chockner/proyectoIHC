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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            //$table->string('document_id',8)->nullable()->unique();
            $table->string('email')->unique()->nullable(); // correo electrónico único
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('address',70)->nullable();
            $table->string('phone',12)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender',1)->nullable(); // 0= femenino, 1= masculino
            $table->string('photo')->nullable(); // ruta de la foto
            $table->string('civil_status',1)->nullable(); // estado civil 0= soltero, 1= casado, 2= viudo, 3= divorciado
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            /* $table->string('country')->default('Peru'); */
            $table->timestamps(0);
            $table->softDeletes(); // opcional, pero útil para eliminar perfiles sin borrarlos de la base de datos
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('profiles');
    }
};
