@extends('layouts.app')

@section('title', 'Cancelar Pedido')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">Cancelar Pedido</h1>

        <div class="bg-white shadow rounded p-6">
            <p class="mb-4 text-gray-700">
                ¿Estás seguro de que querés cancelar el pedido <strong>#{{ $pedido->id }}</strong> programado para el
                <strong>{{ $pedido->fecha_entrega }}</strong> a las <strong>{{ $pedido->hora_entrega }}</strong>?
            </p>

            <div class="mb-4">
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

            <form method="POST" action="{{ route('pedido.cancelar', $pedido->id) }}">
                @csrf
                @method('PUT')

                <div class="flex justify-between items-center">
                    <a href="{{ route('cliente.historial') }}" class="text-sm text-blue-600 underline">
                        Volver al historial
                    </a>
                    <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        Cancelar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
