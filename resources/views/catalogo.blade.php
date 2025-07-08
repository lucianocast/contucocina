@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="container mx-auto px-4 py-6">

    <h1 class="text-3xl font-bold mb-6 text-center">Catálogo de Productos</h1>

    {{-- Productos Destacados --}}
    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Ejemplo de producto -->
            <div class="border rounded p-4 shadow">
                <h3 class="font-bold">Torta de Chocolate</h3>
                <p>Clásica torta húmeda con cobertura</p>
                <span class="text-green-600 font-semibold">$4.500</span>
            </div>
        </div>
    </section>

    {{-- Ofertas --}}
    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">Ofertas</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="border rounded p-4 shadow">
                <h3 class="font-bold">Combo 4x3</h3>
                <p>Llevá 4 cookies, pagá solo 3</p>
                <span class="text-red-600 font-semibold">$1.800</span>
            </div>
        </div>
    </section>

    {{-- Populares --}}
    <section>
        <h2 class="text-xl font-semibold mb-4">Más Populares</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="border rounded p-4 shadow">
                <h3 class="font-bold">Cheesecake de Frutilla</h3>
                <p>Delicioso y suave</p>
                <span class="text-gray-700 font-semibold">$5.000</span>
            </div>
        </div>
    </section>

</div>
@endsection
