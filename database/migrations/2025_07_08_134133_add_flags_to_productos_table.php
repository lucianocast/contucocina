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
    Schema::table('productos', function (Blueprint $table) {
        $table->boolean('destacado')->default(false);
        $table->boolean('oferta')->default(false);
        $table->boolean('popular')->default(false);
    });
}

public function down(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn(['destacado', 'oferta', 'popular']);
    });
}

};
