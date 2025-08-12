<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTotalToPedidos extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('total', 12, 2)->default(0)->after('estado');
        });

        DB::statement("
            UPDATE pedidos p
            SET total = COALESCE(s.sum_subtotal, 0)
            FROM (
                SELECT pedido_id, SUM(subtotal)::numeric(12,2) AS sum_subtotal
                FROM item_pedidos
                GROUP BY pedido_id
            ) s
            WHERE p.id = s.pedido_id
        ");

        DB::statement("UPDATE pedidos SET total = 0 WHERE total IS NULL");
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
}
