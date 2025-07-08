<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\ItemPedido;

class PedidoController extends Controller
{
    /**
     * Formulario para realizar un pedido.
     */
    public function create()
    {
        $productos = Producto::where('visible', true)->get();
        return view('cliente.pedido', compact('productos'));
    }

    /**
     * Guarda un nuevo pedido del cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora'  => 'required',
            'productos' => 'required|array',
        ]);

        $pedido = Pedido::create([
            'cliente_id'     => Auth::id(),
            'fecha_entrega'  => $request->fecha,
            'hora_entrega'   => $request->hora,
            'notas'          => $request->notas,
            'estado'         => 'pendiente',
        ]);

        foreach ($request->productos as $producto_id => $cantidad) {
            if ($cantidad > 0) {
                ItemPedido::create([
                    'pedido_id'   => $pedido->id,
                    'producto_id' => $producto_id,
                    'cantidad'    => $cantidad,
                ]);
            }
        }

        return redirect()->route('cliente.historial')->with('success', 'Pedido realizado con éxito.');
    }

    /**
     * Muestra el historial del cliente autenticado.
     */
    public function historial()
    {
        $pedidos = Pedido::with('items.producto')
            ->where('cliente_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('cliente.historial', compact('pedidos'));
    }

    /**
     * Formulario para confirmar cancelación.
     */
    public function confirmarCancelacion($id)
    {
        $pedido = Pedido::with('items.producto')
            ->where('id', $id)
            ->where('cliente_id', Auth::id())
            ->firstOrFail();

        return view('cliente.cancelar_pedido', compact('pedido'));
    }

    /**
     * Marca el pedido como cancelado.
     */
    public function cancelar($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('cliente_id', Auth::id())
            ->firstOrFail();

        if ($pedido->estado !== 'pendiente') {
            return redirect()->route('cliente.historial')->with('error', 'El pedido no puede ser cancelado.');
        }

        $pedido->estado = 'cancelado';
        $pedido->save();

        return redirect()->route('cliente.historial')->with('success', 'Pedido cancelado correctamente.');
    }
}
