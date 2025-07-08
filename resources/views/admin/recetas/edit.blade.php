@extends('layouts.app')

@section('title', 'Editar Receta')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Editar Receta</h1>

        <form action="{{ route('recetas.update', $receta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre" class="block font-semibold mb-1">Nombre de la receta</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $receta->nombre) }}"
                       required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="producto_id" class="block font-semibold mb-1">Producto asociado</label>
                <select name="producto_id" id="producto_id" class="w-full border rounded px-3 py-2">
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}"
                            {{ $producto->id == $receta->producto_id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block font-semibold mb-1">Descripción / Preparación</label>
                <textarea name="descripcion" id="descripcion" rows="5"
                          class="w-full border rounded px-3 py-2">{{ old('descripcion', $receta->descripcion) }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Actualizar Receta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
