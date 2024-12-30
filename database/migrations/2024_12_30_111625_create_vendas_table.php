<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
            
            // Tour 1
            $table->string('tour');
            $table->date('data_tour');
            $table->integer('pax_adulto');
            $table->decimal('preco_adulto', 10, 2);
            $table->integer('pax_infantil')->nullable();
            $table->decimal('preco_infantil', 10, 2)->nullable();

            // Informações de Pagamento
            $table->string('estado_pagamento');
            $table->string('forma_pagamento');
            $table->date('data_pagamento');
            $table->decimal('valor_total', 10, 2);
            $table->decimal('valor_pago', 10, 2);
            $table->decimal('valor_a_pagar', 10, 2);

            $table->text('observacoes')->nullable();
            $table->string('comprovante')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
