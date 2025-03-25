<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venda_id');  // Coluna para armazenar o ID da venda
            $table->string('passport')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
            $table->timestamps();

            // Definindo a chave estrangeira
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
