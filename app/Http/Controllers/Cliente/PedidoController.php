<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\ItemPedido;
use App\Http\Requests\StorePedidoRequest; // ✅ Importamos el Request especializado

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
     * Guarda un nuevo pedido del cliente usando StorePedidoRequest.
     */
    public function store(StorePedidoRequest $request)
    {
        // ✅ Creamos el pedido
        $pedido = Pedido::create([
            'cliente_id'     => Auth::id(),
            'fecha_entrega'  => $request->fecha_entrega,
            'hora_entrega'   => $request->hora_entrega ?? null,
            'notas'          => $request->personalizacion, // según UID
            'estado'         => 'pendiente',
            'forma_pago'     => $request->forma_pago, // opcional
            'tipo_retiro'    => $request->tipo_retiro, // opcional
        ]);

        // ✅ Guardamos ítems del pedido
        foreach ($request->items as $item) {
            if (!empty($item['cantidad']) && $item['cantidad'] > 0) {
                ItemPedido::create([
                    'pedido_id'   => $pedido->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad'    => $item['cantidad'],
                ]);
            }
        }

        return redirect()
            ->route('cliente.historial')
            ->with('success', 'Pedido realizado con éxito.');
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
