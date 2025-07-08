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
    $destacados = Producto::where('destacado', true)->where('visible', true)->get();
    $ofertas = Producto::where('oferta', true)->where('visible', true)->get();
    $populares = Producto::where('popular', true)->where('visible', true)->get();

    // Obtener las categorías únicas de productos visibles y que no sean destacados, ofertas ni populares
    $categorias = Producto::where('visible', true)
        ->where('destacado', false)
        ->where('oferta', false)
        ->where('popular', false)
        ->select('categoria')
        ->distinct()
        ->pluck('categoria');

    // Para cada categoría, obtener sus productos
    $productosPorCategoria = [];
    foreach ($categorias as $categoria) {
        $productosPorCategoria[$categoria] = Producto::where('categoria', $categoria)
            ->where('visible', true)
            ->where('destacado', false)
            ->where('oferta', false)
            ->where('popular', false)
            ->get();
    }

    return view('catalogo', compact(
        'destacados',
        'ofertas',
        'populares',
        'productosPorCategoria'
    ));
}
}
