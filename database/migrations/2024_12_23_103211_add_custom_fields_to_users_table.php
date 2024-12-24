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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('Vendedor'); // Nível do usuário
            $table->string('rut')->nullable();          // CPF ou RUT
            $table->string('whatsapp')->nullable();     // WhatsApp
            $table->decimal('commission_percentage', 5, 2)->nullable(); // Comissão %
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'rut', 'whatsapp', 'commission_percentage']);
        });
    }
};
