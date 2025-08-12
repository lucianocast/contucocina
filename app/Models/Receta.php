<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'producto_id',
        'descripcion',
        'insumos',
        'cantidades',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}

