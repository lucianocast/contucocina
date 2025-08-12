@extends('layouts.app')
@section('title','Fechas no disponibles')

@section('content')
<div class="container mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Fechas no disponibles</h1>
    <a href="{{ route('no-disponibles.create') }}" class="border px-4 py-2 rounded">Nueva fecha</a>
  </div>

  @if(session('ok'))
    <div class="mb-4 p-3 border rounded bg-green-50">{{ session('ok') }}</div>
  @endif

  <div class="overflow-x-auto border rounded">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2 px-3">Fecha</th>
          <th class="text-left py-2 px-3">Motivo</th>
          <th class="text-right py-2 px-3">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $it)
          <tr class="border-b">
            <td class="py-2 px-3 font-medium">{{ $it->fecha->format('d/m/Y') }}</td>
            <td class="py-2 px-3">{{ $it->motivo ?? '—' }}</td>
            <td class="py-2 px-3 text-right">
              <a href="{{ route('no-disponibles.edit', $it) }}" class="border px-3 py-1 rounded">Editar</a>
              <form action="{{ route('no-disponibles.destroy', $it) }}" method="post" class="inline"
                    onsubmit="return confirm('¿Eliminar esta fecha?')">
                @csrf @method('DELETE')
                <button class="border px-3 py-1 rounded">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="py-6 px-3 text-center text-gray-600">No hay fechas cargadas.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $items->links() }}
  </div>
</div>
@endsection
