<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $totales = [
            'pedidos'     => Pedido::count(),
            'pendientes'  => Pedido::where('estado', 'pendiente')->count(),
            'entregados'  => Pedido::where('estado', 'entregado')->count(),
            'cancelados'  => Pedido::where('estado', 'cancelado')->count(),
            'ventas_mes'  => Pedido::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                                   ->sum('total'),
        ];

        // Top 5 productos más vendidos
        $topProductos = DB::table('item_pedidos')
            ->select('producto_id', DB::raw('SUM(cantidad) as qty'))
            ->groupBy('producto_id')
            ->orderByDesc('qty')
            ->limit(5)
            ->get()
            ->map(function ($r) {
                $r->producto = \App\Models\Producto::find($r->producto_id)?->nombre ?? 'N/D';
                return $r;
            });

        // Clientes con más pedidos
        $topClientes = DB::table('pedidos')
            ->select('cliente_id', DB::raw('COUNT(*) as pedidos'))
            ->groupBy('cliente_id')
            ->orderByDesc('pedidos')
            ->limit(5)->get();

        return view('admin.reportes.index', compact('totales','topProductos','topClientes'));
    }
    public function show($id)
    {
        // Implementar lógica para mostrar un reporte específico si es necesario
        abort(404, 'Reporte no encontrado.');
    }

}
