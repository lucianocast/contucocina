@extends('layouts.app')

@section('title', 'Gestión de Recetas')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Gestión de Recetas</h1>

        <div class="mb-6 text-right">
            <a href="{{ route('recetas.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                + Nueva Receta
            </a>
        </div>

        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Producto Asociado</th>
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recetas as $receta)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $receta->nombre }}</td>
                        <td class="px-4 py-2">{{ $receta->producto->nombre ?? 'Sin producto' }}</td>
                        <td class="px-4 py-2">{{ Str::limit($receta->descripcion, 40) }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('recetas.edit', $receta->id) }}"
                               class="text-blue-600 hover:underline mr-2">Editar</a>
                            <form action="{{ route('recetas.destroy', $receta->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('¿Eliminar esta receta?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">No hay recetas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
