<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'pedido_id',
        'estado',
        'total',
        'fecha_entrega',
        'hora_entrega',
        'forma_pago',
        'comentario',
        // Agregá aquí otros campos si corresponde
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
    public function items()
    {
        return $this->hasMany(ItemPedido::class, 'pedido_id');
    }
}
