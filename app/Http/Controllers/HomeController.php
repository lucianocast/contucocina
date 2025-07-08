<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Producto;


class HomeController extends Controller
{
    /**
     * Muestra la página de inicio o redirige según rol.
     */
    public function index()
    {

        if (Auth::check()) {
            $rol = Auth::user()->rol;

            if ($rol === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('catalogo');
        }
    $destacados = Producto::where('destacado', true)->where('visible', true)->get();
    $ofertas    = Producto::where('oferta', true)->where('visible', true)->get();
    $populares  = Producto::where('popular', true)->where('visible', true)->get();

    return view('welcome', compact('destacados', 'ofertas', 'populares'));
    

        // Usuario no autenticado → pantalla de bienvenida
        return view('welcome');
    }
}
