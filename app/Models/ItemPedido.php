<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    public function pedido()
{
    return $this->belongsTo(Pedido::class);
}

public function producto()
{
    return $this->belongsTo(Producto::class);
}
}
