<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoRecibidoController extends Controller
{
    /**
     * Muestra todos los pedidos recibidos.
     */
    public function index()
    {
        $pedidos = Pedido::with('cliente', 'items.producto')
                         ->orderByDesc('created_at')
                         ->get();

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
