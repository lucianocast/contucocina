@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Panel de Administración</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Gestión de Productos -->
            <a href="{{ route('productos.index') }}"
               class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-blue-100 transition">
                <h2 class="text-xl font-semibold mb-2">Gestión de Productos</h2>
                <p class="text-sm text-gray-600">Agregar, modificar o desactivar productos</p>
            </a>

            <!-- Gestión de Recetas -->
            <a href="{{ route('recetas.index') }}"
               class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-blue-100 transition">
                <h2 class="text-xl font-semibold mb-2">Gestión de Recetas</h2>
                <p class="text-sm text-gray-600">Administrar recetas internas asociadas a productos</p>
            </a>

            <!-- Ver Pedidos Recibidos -->
            <a href="{{ route('pedidos.recibidos') }}"
               class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-blue-100 transition">
                <h2 class="text-xl font-semibold mb-2">Pedidos Recibidos</h2>
                <p class="text-sm text-gray-600">Ver y gestionar pedidos realizados por los clientes</p>
            </a>
        </div>
    </div>
</div>
@endsection
