<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubtotalToItemPedidos extends Migration
{
    public function up(): void
    {
        Schema::table('item_pedidos', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->default(0)->after('cantidad');
        });
    }

    public function down(): void
    {
        Schema::table('item_pedidos', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
}