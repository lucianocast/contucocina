@extends('layouts.app')
@section('title','Gestión de usuarios')

@section('content')
<div class="container mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Usuarios</h1>
    <a href="{{ route('usuarios.create') }}" class="border px-4 py-2 rounded">Nuevo usuario</a>
  </div>

  @if(session('ok'))   <div class="mb-4 p-3 border rounded bg-green-50">{{ session('ok') }}</div> @endif
  @if(session('error'))<div class="mb-4 p-3 border rounded bg-red-50">{{ session('error') }}</div> @endif

  {{-- Filtros --}}
  <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <div class="md:col-span-2">
      <input type="text" name="buscar" class="w-full border rounded px-3 py-2"
             placeholder="Buscar por nombre o correo…" value="{{ request('buscar') }}">
    </div>
    <div>
      <select name="rol" class="w-full border rounded px-3 py-2">
        <option value="">Rol: Todos</option>
        <option value="admin"   {{ request('rol')==='admin' ? 'selected' : '' }}>Administrador</option>
        <option value="cliente" {{ request('rol')==='cliente' ? 'selected' : '' }}>Cliente</option>
      </select>
    </div>
    <div>
      <select name="estado" class="w-full border rounded px-3 py-2">
        <option value="">Estado: Todos</option>
        <option value="activo"   {{ request('estado')==='activo' ? 'selected' : '' }}>Activo</option>
        <option value="inactivo" {{ request('estado')==='inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>
    <div>
      <button class="border px-4 py-2 rounded">Filtrar</button>
      <a href="{{ route('usuarios.index') }}" class="px-4 py-2">Limpiar</a>
    </div>
  </form>

  <div class="overflow-x-auto border rounded">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2 px-3">Nombre</th>
          <th class="text-left py-2 px-3">Correo</th>
          <th class="text-left py-2 px-3">Rol</th>
          <th class="text-center py-2 px-3">Estado</th>
          <th class="text-right py-2 px-3">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($usuarios as $u)
          <tr class="border-b">
            <td class="py-2 px-3">{{ $u->name }}</td>
            <td class="py-2 px-3">{{ $u->email }}</td>
            <td class="py-2 px-3">{{ ucfirst($u->rol) }}</td>
            <td class="py-2 px-3 text-center">
              @if($u->active)
                <span class="px-2 py-1 border rounded text-xs">Activo</span>
              @else
                <span class="px-2 py-1 border rounded text-xs">Inactivo</span>
              @endif
            </td>
            <td class="py-2 px-3 text-right">
              <a href="{{ route('usuarios.edit',$u) }}" class="border px-3 py-1 rounded">Editar</a>
              <form action="{{ route('usuarios.toggle',$u) }}" method="post" class="inline"
                    onsubmit="return confirm('¿Cambiar estado de este usuario?')">
                @csrf @method('PATCH')
                <button class="border px-3 py-1 rounded">
                  {{ $u->active ? 'Desactivar' : 'Activar' }}
                </button>
              </form>
              <form action="{{ route('usuarios.destroy',$u) }}" method="post" class="inline"
                    onsubmit="return confirm('¿Eliminar usuario?')">
                @csrf @method('DELETE')
                <button class="border px-3 py-1 rounded">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="py-6 text-center text-gray-600">No hay usuarios.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $usuarios->links() }}
  </div>
</div>
@endsection
