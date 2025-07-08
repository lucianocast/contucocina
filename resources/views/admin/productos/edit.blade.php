@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Editar Producto</h1>

        <form action="{{ route('productos.update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre" class="block font-semibold mb-1">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="precio" class="block font-semibold mb-1">Precio</label>
                <input type="number" name="precio" id="precio" step="0.01" value="{{ old('precio', $producto->precio) }}" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="categoria" class="block font-semibold mb-1">Categoría</label>
                <select name="categoria" id="categoria" class="w-full border rounded px-3 py-2">
                    <option value="">Sin categoría</option>
                    <option value="Tortas" {{ old('categoria', $producto->categoria) == 'Tortas' ? 'selected' : '' }}>Tortas</option>
                    <option value="Cheesecakes" {{ old('categoria', $producto->categoria) == 'Cheesecakes' ? 'selected' : '' }}>Cheesecakes</option>
                    <option value="Tartas" {{ old('categoria', $producto->categoria) == 'Tartas' ? 'selected' : '' }}>Tartas</option>
                    <option value="Postres clásicos" {{ old('categoria', $producto->categoria) == 'Postres clásicos' ? 'selected' : '' }}>Postres clásicos</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="destacado" value="1" {{ old('destacado', $producto->destacado) ? 'checked' : '' }}>
                    <span class="ml-2">Destacado</span>
                </label>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="oferta" value="1" {{ old('oferta', $producto->oferta) ? 'checked' : '' }}>
                    <span class="ml-2">Oferta</span>
                </label>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="popular" value="1" {{ old('popular', $producto->popular) ? 'checked' : '' }}>
                    <span class="ml-2">Más Popular</span>
                </label>
            </div>

            <div class="mb-4">
                <label for="visible" class="block font-semibold mb-1">Visibilidad en catálogo</label>
                <select name="visible" id="visible" class="w-full border rounded px-3 py-2">
                    <option value="1" {{ old('visible', $producto->visible) == 1 ? 'selected' : '' }}>Visible</option>
                    <option value="0" {{ old('visible', $producto->visible) == 0 ? 'selected' : '' }}>Oculto</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
