@extends('layouts.app')
@section('title','Nuevo combo')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Nuevo combo</h1>

  <form action="{{ route('combos.store') }}" method="post">
    @csrf
    @include('admin.combos._form', ['combo' => new \App\Models\Combo()])
    <div class="mt-4 flex items-center gap-2">
      <button type="submit" class="border px-4 py-2 rounded">Guardar</button>
      <a href="{{ route('combos.index') }}" class="px-4 py-2">Cancelar</a>
    </div>
  </form>
</div>
@endsection
