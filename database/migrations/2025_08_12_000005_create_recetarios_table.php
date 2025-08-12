<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recetarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');                // nombre lógico mostrado
            $table->string('categoria')->nullable(); // ej: bizcochos, cremas, glaseados
            $table->string('path');                  // storage/app/recetario/xxxx.ext
            $table->unsignedBigInteger('user_id')->nullable(); // quién subió
            $table->timestamps();

            $table->index('categoria');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetarios');
    }
};
