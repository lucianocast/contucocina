<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
    $table->date('fecha_entrega');
    $table->time('hora_entrega');
    $table->text('notas')->nullable();
    $table->string('estado')->default('pendiente');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
