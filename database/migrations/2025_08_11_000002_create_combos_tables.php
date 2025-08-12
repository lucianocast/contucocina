<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('combos', function (Blueprint $t) {
      $t->id();
      $t->string('nombre');
      $t->decimal('precio_combo', 12, 2);
      $t->boolean('activo')->default(true);
      $t->timestamps();
    });

    Schema::create('combo_producto', function (Blueprint $t) {
      $t->unsignedBigInteger('combo_id');
      $t->unsignedBigInteger('producto_id');
      $t->integer('cantidad')->default(1);
      $t->primary(['combo_id','producto_id']);
      $t->foreign('combo_id')->references('id')->on('combos')->cascadeOnDelete();
      $t->foreign('producto_id')->references('id')->on('productos')->cascadeOnDelete();
    });
  }
  public function down(): void {
    Schema::dropIfExists('combo_producto');
    Schema::dropIfExists('combos');
  }
};
