<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistica extends Model
{
    use HasFactory;

    // Especificando o nome da tabela no banco de dados
    protected $table = 'logistics';  

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'venda_id',
        'data',             // Data do tour
        'hora',             // Hora do tour
        'nome',             // Nome do cliente
        'tour',
        'pax_total',        // Total de passageiros
        'endereco',         // Endereço
        'hotel',            // Nome do hotel
        'estado_pagamento', // Estado do pagamento
        'telefone',         // Telefone
        'vendedor',         // Vendedor
        'valor_total',      // Valor total
        'condutor',         // Motorista
        'guia',             // Guia
        'valor_pago',       // Valor pago
        'valor_a_pagar',    // Valor a pagar
        'voucher',          // Voucher
        'observacao',       // Observações
        'conferido',        // Conferido
    ];

    /**
     * Relacionamento com a tabela de Vendas
     */
    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    /**
     * Relacionamento com a tabela de Users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
