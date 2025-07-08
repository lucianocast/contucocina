<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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

        // Usuario no autenticado → pantalla de bienvenida
        return view('welcome');
    }
}
