<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class CatalogoController extends Controller
{
    /**
     * Muestra el catálogo de productos visibles.
     */
    public function index()
    {
        $productos = Producto::where('visible', true)->get();

        return view('catalogo', compact('productos'));
    }
}
