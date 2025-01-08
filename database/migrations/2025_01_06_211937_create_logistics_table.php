<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabela de Logística
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->date('data'); // Data do agendamento
            $table->time('hora'); // Hora do agendamento
            $table->foreignId('venda_id')->constrained('vendas')->onDelete('cascade'); // Relacionamento com vendas
            $table->string('nome'); // Nome do cliente
            $table->string('tour');
            $table->integer('pax_total'); // Total de passageiros
            $table->string('endereco'); // Endereço do cliente
            $table->string('hotel'); // Nome do hotel
            $table->string('estado_pagamento'); // Estado do pagamento
            $table->string('telefone'); // Telefone
            $table->string('vendedor'); // Vendedor responsável
            $table->decimal('valor_total', 10, 2); // Valor total
            $table->string('condutor')->nullable(); // Motorista do tour (opcional)
            $table->string('guia')->nullable(); // Guia do tour (opcional)
            $table->decimal('valor_pago', 10, 2); // Valor pago
            $table->decimal('valor_a_pagar', 10, 2); // Valor a pagar
            $table->string('voucher'); // Código do voucher
            $table->string('observacao')->nullable(); // Observação (opcional)
            $table->string('conferido')->nullable(); // Conferido (opcional)
            $table->timestamps(); // Campos de criação e atualização
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistics');
    }
}
