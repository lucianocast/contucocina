@extends('layouts.app')
@section('title','Editar fecha no disponible')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Editar fecha no disponible</h1>

  <form action="{{ route('no-disponibles.update', $no_disponible) }}" method="post">
    @method('PUT')
    @include('admin.no_disponibles._form', ['no_disponible' => $no_disponible])
  </form>
</div>
@endsection
