<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'precio',
        'visible',
        'categoria',
        'destacado', 
        'oferta', 
        'popular',
        'imagen',
    ];
    
}
