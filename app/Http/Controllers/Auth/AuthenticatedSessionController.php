<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'El email es obligatorio.',
        'email.email' => 'El email debe ser válido.',
        'password.required' => 'La contraseña es obligatoria.',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();
    if (!$user) {
        return back()->withErrors([
            'email' => 'El correo ingresado no está registrado.',
        ])->onlyInput('email');
    }

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        return back()->withErrors([
            'password' => 'La contraseña es incorrecta.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    // Redireccionar según el rol
    $rol = auth()->user()->rol;

    if ($rol === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($rol === 'cliente') {
        return redirect()->route('cliente.pedido');
    }

    // Si no tiene rol válido, cerrar sesión y mostrar error
    Auth::logout();
    Session::flush();
    return redirect('/login')->withErrors(['email' => 'Rol no autorizado.']);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
