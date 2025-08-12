@extends('layouts.app')
@section('title','Editar usuario')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Editar usuario</h1>

  @if ($errors->any())
    <div class="mb-4 p-3 border rounded bg-red-50 text-red-700">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('usuarios.update', $usuario) }}">
    @csrf @method('PUT')
    @include('admin.usuarios._form', ['usuario'=>$usuario])
  </form>
</div>
@endsection
