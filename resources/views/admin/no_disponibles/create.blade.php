@extends('layouts.app')
@section('title','Nueva fecha no disponible')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Nueva fecha no disponible</h1>

  <form action="{{ route('no-disponibles.store') }}" method="post">
    @include('admin.no_disponibles._form')
  </form>
</div>
@endsection
