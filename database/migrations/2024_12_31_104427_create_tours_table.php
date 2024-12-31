<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained()->onDelete('cascade'); // Relacionamento com 'vendas'
            $table->string('tour');
            $table->date('data_tour');
            $table->integer('pax_adulto');
            $table->decimal('preco_adulto', 8, 2);
            $table->integer('pax_infantil')->nullable();
            $table->decimal('preco_infantil', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
