<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'venda_id',        // Chave estrangeira para associar à venda
        'tour',
        'data_tour',
        'pax_adulto',
        'preco_adulto',
        'pax_infantil',
        'preco_infantil'
    ];

    // Relacionamento inverso
    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}

