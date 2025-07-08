<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
    ];
// Relación con Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}