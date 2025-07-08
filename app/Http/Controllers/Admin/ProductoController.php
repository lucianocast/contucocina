<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'precio'    => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:100',
            'visible'   => 'required|boolean',
        ]);
        Producto::create([
        'nombre'       => $request->nombre,
        'precio'       => $request->precio,
        'descripcion'  => $request->descripcion,
        'categoria'    => $request->categoria,
        'visible'      => $request->visible,
        'destacado'    => $request->has('destacado'),
        'oferta'       => $request->has('oferta'),
        'popular'  => $request->has('popular'),
    ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'precio'    => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:100',
            'visible'   => 'required|boolean',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update([
        'nombre'       => $request->nombre,
        'precio'       => $request->precio,
        'categoria'    => $request->categoria,
        'visible'      => $request->visible,
        'destacado'    => $request->has('destacado'),
        'oferta'       => $request->has('oferta'),
        'popular'  => $request->has('popular'),
    ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}
