{{-- resources/views/admin/reportes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Reportes e indicadores')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-6">Reportes e indicadores</h1>

  {{-- KPIs --}}
  <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    <div class="p-4 border rounded">
      <div class="text-sm text-gray-600">Pedidos</div>
      <div class="text-2xl font-bold">{{ $totales['pedidos'] ?? 0 }}</div>
    </div>
    <div class="p-4 border rounded">
      <div class="text-sm text-gray-600">Pendientes</div>
      <div class="text-2xl font-bold">{{ $totales['pendientes'] ?? 0 }}</div>
    </div>
    <div class="p-4 border rounded">
      <div class="text-sm text-gray-600">Entregados</div>
      <div class="text-2xl font-bold">{{ $totales['entregados'] ?? 0 }}</div>
    </div>
    <div class="p-4 border rounded">
      <div class="text-sm text-gray-600">Cancelados</div>
      <div class="text-2xl font-bold">{{ $totales['cancelados'] ?? 0 }}</div>
    </div>
    <div class="p-4 border rounded">
      <div class="text-sm text-gray-600">Ventas del mes</div>
      <div class="text-2xl font-bold">
        $ {{ number_format($totales['ventas_mes'] ?? 0, 2, ',', '.') }}
      </div>
    </div>
  </div>

  {{-- Fila de dos columnas: Top productos / Clientes frecuentes --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Top 5 productos --}}
    <div class="border rounded">
      <div class="px-4 py-3 border-b">
        <h2 class="text-lg font-semibold">Top 5 productos más vendidos</h2>
      </div>
      <div class="p-4 overflow-x-auto">
        @if(isset($topProductos) && $topProductos->count())
          <table class="min-w-full text-sm">
            <thead>
              <tr class="border-b">
                <th class="text-left py-2 pr-2">#</th>
                <th class="text-left py-2 pr-2">Producto</th>
                <th class="text-right py-2">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topProductos as $i => $p)
              <tr class="border-b">
                <td class="py-2 pr-2">{{ $i+1 }}</td>
                <td class="py-2 pr-2">{{ $p->producto ?? 'N/D' }}</td>
                <td class="py-2 text-right">{{ $p->qty }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="text-gray-600">No hay datos suficientes para esta sección.</div>
        @endif
      </div>
    </div>

    {{-- Clientes frecuentes --}}
    <div class="border rounded">
      <div class="px-4 py-3 border-b">
        <h2 class="text-lg font-semibold">Clientes con más pedidos</h2>
      </div>
      <div class="p-4 overflow-x-auto">
        @if(isset($topClientes) && $topClientes->count())
          <table class="min-w-full text-sm">
            <thead>
              <tr class="border-b">
                <th class="text-left py-2 pr-2">#</th>
                <th class="text-left py-2 pr-2">Cliente</th>
                <th class="text-right py-2">Pedidos</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topClientes as $i => $c)
              <tr class="border-b">
                <td class="py-2 pr-2">{{ $i+1 }}</td>
                <td class="py-2 pr-2">
                  {{-- Si tenés relación con User, podés resolver el nombre; dejo fallback al ID --}}
                  @php
                    $cliente = \App\Models\User::find($c->cliente_id);
                  @endphp
                  {{ $cliente?->name ?? ('ID '.$c->cliente_id) }}
                </td>
                <td class="py-2 text-right">{{ $c->pedidos }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="text-gray-600">No hay datos suficientes para esta sección.</div>
        @endif
      </div>
    </div>

  </div>

  {{-- (Opcional) Sección futura: filtros por rango de fechas --}}
  {{-- 
  <div class="mt-8 border rounded p-4">
    <form method="get" action="{{ route('admin.reportes') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm text-gray-600">Desde</label>
        <input type="date" name="desde" class="w-full border rounded px-2 py-1" value="{{ request('desde') }}">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Hasta</label>
        <input type="date" name="hasta" class="w-full border rounded px-2 py-1" value="{{ request('hasta') }}">
      </div>
      <div class="md:col-span-2 flex items-end">
        <button class="border rounded px-4 py-2">Filtrar</button>
      </div>
    </form>
  </div>
  --}}

</div>
@endsection
