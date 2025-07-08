@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-10">Catálogo de Productos</h1>

    {{-- Sección: Destacados --}}
    <h2 class="text-xl font-semibold mb-4">Destacados</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        @forelse ($destacados as $producto)
            <div class="border rounded p-4 shadow-sm hover:shadow-md transition">
                <p class="font-bold">{{ $producto->nombre }}</p>
                <p class="text-sm text-gray-600">{{ $producto->descripcion }}</p>
                <p class="text-green-600 font-semibold mt-2">${{ number_format($producto->precio, 0, ',', '.') }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500 col-span-full">No hay productos destacados por el momento.</p>
        @endforelse
    </div>

    {{-- Sección: Ofertas --}}
    <h2 class="text-xl font-semibold mb-4">Ofertas</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        @forelse ($ofertas as $producto)
            <div class="border rounded p-4 shadow-sm hover:shadow-md transition">
                <p class="font-bold">{{ $producto->nombre }}</p>
                <p class="text-sm text-gray-600">{{ $producto->descripcion }}</p>
                <p class="text-red-600 font-semibold mt-2">${{ number_format($producto->precio, 0, ',', '.') }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500 col-span-full">No hay ofertas disponibles.</p>
        @endforelse
    </div>

    {{-- Sección: Más Populares --}}
    <h2 class="text-xl font-semibold mb-4">Más Populares</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @forelse ($populares as $producto)
            <div class="border rounded p-4 shadow-sm hover:shadow-md transition">
                <p class="font-bold">{{ $producto->nombre }}</p>
                <p class="text-sm text-gray-600">{{ $producto->descripcion }}</p>
                <p class="text-blue-600 font-semibold mt-2">${{ number_format($producto->precio, 0, ',', '.') }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500 col-span-full">Aún no hay productos populares.</p>
        @endforelse
    </div>
    @foreach ($productosPorCategoria as $categoria => $productos)
        <h3 class="mt-8 text-lg font-semibold">{{ ucfirst($categoria) }}</h3>

        @if ($productos->isEmpty())
            <p>No hay productos en esta categoría.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                @foreach ($productos as $producto)
                    <div class="border p-3 rounded shadow">
                        <h4 class="font-bold">{{ $producto->nombre }}</h4>
                        <p class="text-sm">{{ $producto->descripcion }}</p>
                        <p class="text-pink-600 font-semibold mt-1">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

</div>
@endsection
