@extends('layouts.app')
@section('title','Recetario privado')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Recetario privado</h1>

  @if(session('ok'))
    <div class="mb-4 p-3 border rounded bg-green-50">{{ session('ok') }}</div>
  @endif
  @if($errors->any())
    <div class="mb-4 p-3 border rounded bg-red-50">
      <ul class="list-disc ml-5 text-sm">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Filtros --}}
  <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
    <div>
      <label class="block text-sm text-gray-600 mb-1">Categoría</label>
      <select name="categoria" class="w-full border rounded px-3 py-2">
        <option value="">Todas</option>
        @foreach($categorias as $cat)
          <option value="{{ $cat }}" {{ request('categoria')===$cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
    </div>
    <div class="md:col-span-2">
      <label class="block text-sm text-gray-600 mb-1">Buscar</label>
      <input type="text" name="buscar" class="w-full border rounded px-3 py-2"
             placeholder="Nombre o categoría…" value="{{ request('buscar') }}">
    </div>
    <div class="flex items-end">
      <button class="border px-4 py-2 rounded">Filtrar</button>
      <a href="{{ route('recetario.index') }}" class="ml-2 px-4 py-2">Limpiar</a>
    </div>
  </form>

  {{-- Form de carga --}}
  <div class="border rounded mb-6">
    <div class="px-4 py-3 border-b">
      <h2 class="text-lg font-semibold">Subir nuevo archivo</h2>
    </div>
    <div class="p-4">
      <form method="post" action="{{ route('recetario.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @csrf
        <div>
          <label class="block text-sm text-gray-600 mb-1">Nombre</label>
          <input type="text" name="nombre" class="w-full border rounded px-3 py-2" required value="{{ old('nombre') }}">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Categoría (opcional)</label>
          <input type="text" name="categoria" class="w-full border rounded px-3 py-2" value="{{ old('categoria') }}">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Archivo</label>
          <input type="file" name="archivo" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="md:col-span-3">
          <button class="border px-4 py-2 rounded">Subir</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Listado --}}
  <div class="overflow-x-auto border rounded">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2 px-3">Nombre</th>
          <th class="text-left py-2 px-3">Categoría</th>
          <th class="text-left py-2 px-3">Subido por</th>
          <th class="text-left py-2 px-3">Fecha</th>
          <th class="text-right py-2 px-3">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($files as $f)
          <tr class="border-b">
            <td class="py-2 px-3">{{ $f->nombre }}</td>
            <td class="py-2 px-3">{{ $f->categoria ?? '—' }}</td>
            <td class="py-2 px-3">{{ $f->usuario?->name ?? '—' }}</td>
            <td class="py-2 px-3">{{ $f->created_at->format('d/m/Y H:i') }}</td>
            <td class="py-2 px-3 text-right">
              <a href="{{ route('recetario.download', $f->id) }}" class="border px-3 py-1 rounded">Descargar</a>
              <form action="{{ route('recetario.destroy', $f->id) }}" method="post" class="inline"
                    onsubmit="return confirm('¿Eliminar este archivo?')">
                @csrf @method('DELETE')
                <button class="border px-3 py-1 rounded">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="py-6 text-center text-gray-600">No hay archivos en el recetario.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $files->links() }}
  </div>
</div>
@endsection
