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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            
            //$table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('document_id',8)->unique(); // DNI como identificador único
            $table->string('password');
            $table->rememberToken(); // opcional pero Laravel lo usa para "recordarme"
            $table->timestamps(0);
            $table->softDeletes(); // opcional, pero útil para eliminar usuarios sin borrarlos de la base de datos
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            //$table->string('email')->primary();
            $table->string('document_id', 8)->primary(); // DNI como identificador único
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
