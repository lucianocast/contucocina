<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoDisponibilidadesTable extends Migration
{
    public function up(): void
    {
        Schema::create('no_disponibilidades', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique();
            $table->string('motivo', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('no_disponibilidades');
    }
}
