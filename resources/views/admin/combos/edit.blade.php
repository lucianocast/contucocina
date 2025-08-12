@extends('layouts.app')
@section('title','Editar combo')

@section('content')
@php
  // $pivot se pasa desde el controlador: producto_id => cantidad
  // Convertimos a Collection por comodidad si viniera como array
  if (is_array($pivot)) $pivot = collect($pivot);
@endphp

<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Editar combo</h1>

  <form action="{{ route('combos.update', $combo) }}" method="post">
    @csrf @method('PUT')
    @include('admin.combos._form', ['combo' => $combo, 'pivot' => $pivot])
    <div class="mt-4 flex items-center gap-2">
      <button type="submit" class="border px-4 py-2 rounded">Actualizar</button>
      <a href="{{ route('combos.index') }}" class="px-4 py-2">Cancelar</a>
    </div>
  </form>
</div>
@endsection
