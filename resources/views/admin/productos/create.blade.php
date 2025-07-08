@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Crear Nuevo Producto</h1>

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block font-semibold mb-1">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="precio" class="block font-semibold mb-1">Precio</label>
                <input type="number" name="precio" id="precio" step="0.01" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="categoria" class="block font-semibold mb-1">Categoría</label>
                <input type="text" name="categoria" id="categoria" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="visible" class="block font-semibold mb-1">Visibilidad en catálogo</label>
                <select name="visible" id="visible" class="w-full border rounded px-3 py-2">
                    <option value="1" selected>Visible</option>
                    <option value="0">Oculto</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
