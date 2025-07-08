@extends('layouts.app')

@section('title', 'Pedidos Recibidos')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Pedidos Recibidos</h1>
        <div class="mb-6 bg-white p-4 rounded shadow">
    <form method="GET" action="{{ route('pedidos.recibidos') }}" class="flex flex-col md:flex-row gap-4 items-center">
        <div class="flex-1">
            <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
            <input type="text" name="cliente" id="cliente" value="{{ request('cliente') }}"
                   class="w-full border rounded px-3 py-2" placeholder="Nombre del cliente">
        </div>

        <div class="flex-1">
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de entrega</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mt-6 md:mt-5">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filtrar
            </button>
            <a href="{{ route('pedidos.recibidos') }}"
               class="ml-2 text-sm text-gray-600 underline hover:text-gray-900">
                Limpiar filtros
            </a>
        </div>
    </form>
</div>
        @if ($pedidos->isEmpty())
            <p class="text-center text-gray-500">No hay pedidos por el momento.</p>
        @else
            <div class="space-y-6">
                @foreach ($pedidos as $pedido)
                    <div class="bg-white shadow rounded p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-lg font-semibold">Pedido #{{ $pedido->id }}</h2>
                            <span class="text-sm">Cliente: <strong>{{ $pedido->cliente->name }}</strong></span>
                        </div>
                        <p><strong>Entrega:</strong> {{ $pedido->fecha_entrega }} - {{ $pedido->hora_entrega }}</p>
                        <p><strong>Estado actual:</strong> {{ ucfirst($pedido->estado) }}</p>

                        <form action="{{ route('pedidos.cambiar_estado', $pedido->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('PUT')

                            <label for="estado_{{ $pedido->id }}" class="block font-semibold mb-1">
                                Cambiar estado:
                            </label>
                            <select name="estado" id="estado_{{ $pedido->id }}" class="border rounded px-3 py-1 w-full mb-2">
                                <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en preparación" {{ $pedido->estado === 'en preparación' ? 'selected' : '' }}>En preparación</option>
                                <option value="listo" {{ $pedido->estado === 'listo' ? 'selected' : '' }}>Listo para entregar</option>
                                <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>

                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Actualizar Estado
                            </button>
                        </form>

                        <div class="mt-4">
                            <p class="font-semibold">Productos:</p>
                            <ul class="list-disc list-inside text-sm text-gray-700">
                                @foreach ($pedido->items as $item)
                                    <li>{{ $item->producto->nombre }} x{{ $item->cantidad }}</li>
                                @endforeach
                            </ul>
                            @if ($pedido->notas)
                                <p class="mt-2 text-sm text-gray-600"><strong>Notas:</strong> {{ $pedido->notas }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
