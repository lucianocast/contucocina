@extends('layouts.app')

@section('title', 'Inicio de Sesión')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Inicio de Sesión</h1>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Correo electrónico</label>
                <input type="email" name="email" id="email" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" id="password" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4 flex justify-between items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="mr-1">
                    <span class="text-sm">Recordarme</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Iniciar Sesión
            </button>
        </form>

        <p class="mt-4 text-center">
            ¿No tenés cuenta?
            <a href="{{ route('register') }}" class="text-blue-600 underline">Registrate</a>
        </p>
    </div>
</div>
@endsection
