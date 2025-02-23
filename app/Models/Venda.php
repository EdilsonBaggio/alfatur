<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendedor',
        'nome',
        'telefone',
        'email',
        'hotel',
        'zona',
        'direcao_hotel',
        'pais_origem',
        'idioma',
        'habitacao',
        'estado_pagamento',
        'forma_pagamento',
        'data_pagamento',
        'valor_total',
        'valor_pago',
        'valor_a_pagar',
        'observacoes',
        'comprovante'
    ];
    
    // Relacionamento com a tabela 'tours'
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function logistica()
    {
        return $this->hasOne(Logistica::class, 'venda_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }

}
