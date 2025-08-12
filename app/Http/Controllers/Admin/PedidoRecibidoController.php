<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoRecibidoController extends Controller
{
    /**
     * Muestra todos los pedidos recibidos, con filtros por cliente y fecha.
     */
    public function index(Request $request)
    {
        $query = Pedido::with('cliente', 'items.producto')
                       ->orderByDesc('created_at');

        // Filtro por nombre del cliente (parcial, insensible a mayúsculas/minúsculas)
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('name', 'ILIKE', '%' . $request->cliente . '%');
            });
        }

        // Filtro por fecha exacta de entrega
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_entrega', $request->fecha);
        }

        $pedidos = $query->get();

        // Recalcula el total por si los items cambiaron (opcional)
        foreach ($pedidos as $pedido) {
            $pedido->total = $pedido->items->sum('subtotal');
        }

        return view('admin.pedidos.index', compact('pedidos'));
    }

    /**
     * Actualiza el estado de un pedido.
     */
    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string|in:pendiente,en preparación,listo,entregado,cancelado',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->estado = $request->estado;
        $pedido->save();

        return redirect()->route('pedidos.recibidos')->with('success', 'Estado del pedido actualizado.');
    }
}
