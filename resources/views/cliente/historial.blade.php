@extends('layouts.app')

@section('title', 'Historial de Pedidos')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-center">Mis Pedidos</h1>

        @if ($pedidos->isEmpty())
            <p class="text-center text-gray-500">Aún no realizaste ningún pedido.</p>
        @else
            <div class="space-y-6">
                @foreach ($pedidos as $pedido)
                    <div class="bg-white shadow rounded p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-lg font-semibold">Pedido #{{ $pedido->id }}</h2>
                            <span class="text-sm text-gray-700">
                                Estado: <strong class="text-blue-700">{{ ucfirst($pedido->estado) }}</strong>
                            </span>
                        </div>
                        <p><strong>Fecha entrega:</strong> {{ $pedido->fecha_entrega }} - {{ $pedido->hora_entrega }}</p>
                        <p><strong>Productos:</strong></p>
                        <ul class="list-disc list-inside text-sm text-gray-700">
                            @foreach ($pedido->items as $item)
                                <li>{{ $item->producto->nombre }} x{{ $item->cantidad }}</li>
                            @endforeach
                        </ul>
                        @if ($pedido->notas)
                            <p class="mt-2 text-sm text-gray-600"><strong>Notas:</strong> {{ $pedido->notas }}</p>
                        @endif

                        @if ($pedido->estado === 'pendiente')
                            <form method="GET" action="{{ route('pedido.confirmar_cancelacion', $pedido->id) }}" class="mt-3">
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Cancelar pedido
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
