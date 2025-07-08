@extends('layouts.app')

@section('title', 'Realizar Pedido')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Realizar Pedido</h1>

        <form action="{{ route('pedido.guardar') }}" method="POST">
            @csrf

            {{-- Selección de productos --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Seleccioná tus productos</h2>

                @forelse ($productos as $producto)
                    <div class="flex items-center mb-3 border p-3 rounded">
                        <label class="flex-1">
                            <strong>{{ $producto->nombre }}</strong><br>
                            <span class="text-sm text-gray-600">{{ $producto->descripcion }}</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="productos[{{ $producto->id }}]" min="0" value="0"
                                   class="w-16 border rounded px-2 py-1">
                            <span class="text-gray-700">${{ number_format($producto->precio, 2) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No hay productos disponibles.</p>
                @endforelse
            </div>

            {{-- Fecha y hora --}}
            <div class="mb-4">
                <label for="fecha" class="block font-semibold mb-1">Fecha de entrega</label>
                <input type="date" name="fecha" id="fecha" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="hora" class="block font-semibold mb-1">Hora aproximada</label>
                <input type="time" name="hora" id="hora" required class="w-full border rounded px-3 py-2">
            </div>

            {{-- Notas --}}
            <div class="mb-6">
                <label for="notas" class="block font-semibold mb-1">Notas adicionales</label>
                <textarea name="notas" id="notas" rows="3"
                          class="w-full border rounded px-3 py-2" placeholder="Indicar personalizaciones, sabores, etc."></textarea>
            </div>

            {{-- Botón --}}
            <div class="text-center">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Confirmar Pedido
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
