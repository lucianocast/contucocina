<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model {
  protected $fillable = ['nombre','precio_combo','activo'];
  public function productos() {
    return $this->belongsToMany(Producto::class, 'combo_producto')
                ->withPivot('cantidad');
  }
}
