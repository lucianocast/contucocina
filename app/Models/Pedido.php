<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function cliente()
{
    return $this->belongsTo(User::class, 'cliente_id');
}

public function items()
{
    return $this->hasMany(ItemPedido::class);
}
}
