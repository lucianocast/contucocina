<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receta;
use App\Models\Producto;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::with('producto')->get();
        return view('admin.recetas.index', compact('recetas'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('admin.recetas.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'producto_id' => 'nullable|exists:productos,id',
            'descripcion' => 'nullable|string',
        ]);

        Receta::create($request->all());

        return redirect()->route('recetas.index')->with('success', 'Receta creada correctamente.');
    }

    public function edit($id)
    {
        $receta = Receta::findOrFail($id);
        $productos = Producto::all();
        return view('admin.recetas.edit', compact('receta', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'producto_id' => 'nullable|exists:productos,id',
            'descripcion' => 'nullable|string',
        ]);

        $receta = Receta::findOrFail($id);
        $receta->update($request->all());

        return redirect()->route('recetas.index')->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $receta = Receta::findOrFail($id);
        $receta->delete();

        return redirect()->route('recetas.index')->with('success', 'Receta eliminada.');
    }
}
