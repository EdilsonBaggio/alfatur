<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('vendedor');
            $table->string('nome');
            $table->string('telefone');
            $table->string('email')->nullable();
            $table->string('hotel');
            $table->string('zona');
            $table->string('direcao_hotel');
            $table->string('habitacao');
            $table->string('pais_origem')->nullable();
            $table->string('idioma')->nullable();
            $table->decimal('valor_total', 10, 2);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
