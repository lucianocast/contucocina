<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoDisponibilidad extends Model
{
    protected $table = 'no_disponibilidades';

    protected $fillable = ['fecha', 'motivo'];

    protected $casts = [
        'fecha' => 'date',
    ];
}
