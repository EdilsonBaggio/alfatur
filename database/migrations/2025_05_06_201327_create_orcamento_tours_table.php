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
        Schema::create('orcamento_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orcamento_id')->constrained()->onDelete('cascade');
            $table->string('tour');
            $table->date('data_tour');
            $table->integer('pax_adulto');
            $table->decimal('preco_adulto', 10, 2);
            $table->integer('pax_infantil')->nullable();
            $table->decimal('preco_infantil', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamento_tours');
    }
};
