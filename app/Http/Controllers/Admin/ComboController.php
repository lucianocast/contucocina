<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ComboController extends Controller
{
    // Lista de combos
    public function index()
    {
        $combos = Combo::with('productos')->paginate(10);
        return view('admin.combos.index', compact('combos'));
    }

    // Formulario de creación
    public function create()
    {
        $productos = Producto::all();
        return view('admin.combos.create', compact('productos'));
    }

    // Guardar nuevo combo
    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'precio_combo'  => 'required|numeric|min:0',
            'productos'     => 'required|array|min:1',
            'cantidades'    => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $combo = Combo::create([
                'nombre'        => $request->nombre,
                'precio_combo'  => $request->precio_combo,
                'activo'        => $request->has('activo'),
            ]);

            // Relacionar productos con cantidades
            $syncData = [];
            foreach ($request->productos as $index => $productoId) {
                $cantidad = (int)($request->cantidades[$index] ?? 1);
                $syncData[$productoId] = ['cantidad' => max(1, $cantidad)];
            }
            $combo->productos()->sync($syncData);
        });

        return redirect()->route('combos.index')->with('ok', 'Combo creado correctamente.');
    }

    // Formulario de edición
    public function edit(Combo $combo)
    {
        $productos = Producto::all();
        // Mapa producto_id => cantidad
        $pivot = $combo->productos()->pluck('combo_producto.cantidad', 'productos.id');

        return view('admin.combos.edit', compact('combo', 'productos', 'pivot'));
    }

    // Actualizar combo
    public function update(Request $request, Combo $combo)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'precio_combo'  => 'required|numeric|min:0',
            'productos'     => 'required|array|min:1',
            'cantidades'    => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request, $combo) {
            $combo->update([
                'nombre'        => $request->nombre,
                'precio_combo'  => $request->precio_combo,
                'activo'        => $request->has('activo'),
            ]);

            // Relacionar productos con cantidades
            $syncData = [];
            foreach ($request->productos as $index => $productoId) {
                $cantidad = (int)($request->cantidades[$index] ?? 1);
                $syncData[$productoId] = ['cantidad' => max(1, $cantidad)];
            }
            $combo->productos()->sync($syncData);
        });

        return redirect()->route('combos.index')->with('ok', 'Combo actualizado correctamente.');
    }

    // Eliminar combo
    public function destroy(Combo $combo)
    {
        $combo->productos()->detach();
        $combo->delete();

        return redirect()->route('combos.index')->with('ok', 'Combo eliminado.');
    }
}
