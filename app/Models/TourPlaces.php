<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPlaces extends Model
{
    protected $fillable = [
        'name', 'price', 'min_price', 'cost', 'child_price', 'child_cost', 'status'
    ];
}
