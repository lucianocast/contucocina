@extends('layouts.app')
@section('title','Combos')

@section('content')
<div class="container mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Combos</h1>
    <a href="{{ route('combos.create') }}" class="border px-4 py-2 rounded">Nuevo combo</a>
  </div>

  @if(session('ok'))
    <div class="mb-4 p-3 border rounded bg-green-50">{{ session('ok') }}</div>
  @endif
  @if(session('error'))
    <div class="mb-4 p-3 border rounded bg-red-50">{{ session('error') }}</div>
  @endif

  <div class="overflow-x-auto border rounded">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2 px-3">Nombre</th>
          <th class="text-right py-2 px-3">Precio</th>
          <th class="text-center py-2 px-3">Activo</th>
          <th class="text-left py-2 px-3">Productos</th>
          <th class="text-right py-2 px-3">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($combos as $combo)
          <tr class="border-b align-top">
            <td class="py-2 px-3 font-medium">{{ $combo->nombre }}</td>
            <td class="py-2 px-3 text-right">$ {{ number_format($combo->precio_combo,2,',','.') }}</td>
            <td class="py-2 px-3 text-center">
              @if($combo->activo)
                <span class="px-2 py-1 border rounded text-xs">Sí</span>
              @else
                <span class="px-2 py-1 border rounded text-xs">No</span>
              @endif
            </td>
            <td class="py-2 px-3">
              @if($combo->productos->count())
                <ul class="list-disc ml-5">
                  @foreach($combo->productos as $p)
                    <li>{{ $p->nombre }} × {{ $p->pivot->cantidad }}</li>
                  @endforeach
                </ul>
              @else
                <span class="text-gray-500">Sin productos</span>
              @endif
            </td>
            <td class="py-2 px-3 text-right">
              <a href="{{ route('combos.edit',$combo) }}" class="border px-3 py-1 rounded">Editar</a>
              <form action="{{ route('combos.destroy',$combo) }}" method="post" class="inline"
                    onsubmit="return confirm('¿Eliminar combo? Esta acción no se puede deshacer.')">
                @csrf @method('DELETE')
                <button class="border px-3 py-1 rounded">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="py-6 px-3 text-center text-gray-600">No hay combos cargados.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $combos->links() }}
  </div>
</div>
@endsection
