@extends('layouts.app')
@section('title','Nuevo usuario')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Nuevo usuario</h1>
  <form method="post" action="{{ route('usuarios.store') }}">
    @include('admin.usuarios._form')
  </form>
</div>
@endsection
