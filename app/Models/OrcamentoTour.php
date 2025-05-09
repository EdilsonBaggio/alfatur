<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoTour extends Model
{
    use HasFactory;

    protected $fillable = [
        'orcamento_id',
        'tour',
        'data_tour',
        'pax_adulto',
        'preco_adulto',
        'pax_infantil',
        'preco_infantil',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }
}
