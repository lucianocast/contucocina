@extends('layouts.app')

@section('title', 'Gestión de Productos')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Gestión de Productos</h1>

        <div class="mb-6 text-right">
            <a href="{{ route('productos.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                + Nuevo Producto
            </a>
        </div>

        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Precio</th>
                    <th class="px-4 py-3">Categoría</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $producto->nombre }}</td>
                        <td class="px-4 py-2">${{ number_format($producto->precio, 2) }}</td>
                        <td class="px-4 py-2">{{ $producto->categoria }}</td>
                        <td class="px-4 py-2">
                            @if ($producto->visible)
                                <span class="text-green-600 font-semibold">Visible</span>
                            @else
                                <span class="text-gray-500">Oculto</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('productos.edit', $producto->id) }}"
                               class="text-blue-600 hover:underline mr-2">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
