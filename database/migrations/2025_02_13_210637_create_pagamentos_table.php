<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained('vendas')->onDelete('cascade');
            $table->string('forma_pagamento');
            $table->date('data_pagamento');
            $table->decimal('valor_pago', 10, 3);
            $table->decimal('valor_a_pagar', 10, 3);
            $table->string('estado_pagamento');
            $table->string('comprovante')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamentos');
    }
};
