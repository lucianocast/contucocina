@extends('layouts.app')

@section('title', 'Registro de Cliente')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Registro de Cliente</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">Nombre</label>
                <input type="text" name="name" id="name" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Correo electrónico</label>
                <input type="email" name="email" id="email" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" id="password" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Registrarse
            </button>
        </form>

        <p class="mt-4 text-center">
            ¿Ya tenés cuenta?
            <a href="{{ route('login') }}" class="text-blue-600 underline">Iniciar sesión</a>
        </p>
    </div>
</div>
@endsection
