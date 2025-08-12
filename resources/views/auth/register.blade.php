@extends('layouts.app')

@section('title', 'Registro de Cliente')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Registro de Cliente</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 border rounded bg-red-50 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Nombre</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2" value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" id="password" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="telefono" class="block text-sm font-medium">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="w-full border rounded px-3 py-2" value="{{ old('telefono') }}">
                @error('telefono')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="direccion" class="block text-sm font-medium">Dirección</label>
                <input type="text" name="direccion" id="direccion" class="w-full border rounded px-3 py-2" value="{{ old('direccion') }}">
                @error('direccion')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
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
