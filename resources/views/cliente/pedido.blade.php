@extends('layouts.app')

@section('title','Nuevo pedido')

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-semibold mb-4">Realizar pedido</h1>

  {{-- Mensajes flash --}}
  @if(session('success'))
    <div class="mb-4 p-3 border rounded bg-green-50">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="mb-4 p-3 border rounded bg-red-50">{{ session('error') }}</div>
  @endif

  {{-- Errores de validación --}}
  @if ($errors->any())
    <div class="mb-4 p-3 border rounded bg-red-50">
      <ul class="list-disc ml-5 text-sm">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('pedido.guardar') }}">
    @csrf

    {{-- Productos (items) --}}
    <div class="border rounded mb-6">
      <div class="px-4 py-3 border-b">
        <h2 class="text-lg font-semibold">Seleccioná tus productos</h2>
        <p class="text-sm text-gray-600">Indicá la cantidad (0 = no incluir).</p>
      </div>
      <div class="p-4 overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead>
          <tr class="border-b">
            <th class="text-left py-2 pr-2">Producto</th>
            <th class="text-left py-2 pr-2">Precio</th>
            <th class="text-right py-2 pr-2">Cantidad</th>
          </tr>
          </thead>
          <tbody>
          @forelse($productos as $i => $p)
            @php
              // valor por defecto de cantidad (postback conserva old)
              $oldItems = old('items', []);
              $cant = 0;
              if (isset($oldItems[$i]['producto_id']) && (int)$oldItems[$i]['producto_id'] === (int)$p->id) {
                  $cant = (int)($oldItems[$i]['cantidad'] ?? 0);
              }
            @endphp
            <tr class="border-b">
              <td class="py-2 pr-2">{{ $p->nombre }}</td>
              <td class="py-2 pr-2">$ {{ number_format($p->precio, 2, ',', '.') }}</td>
              <td class="py-2 pr-2 text-right">
                {{-- Estructura esperada: items[i][producto_id] + items[i][cantidad] --}}
                <input type="hidden" name="items[{{ $i }}][producto_id]" value="{{ $p->id }}">
                <input type="number" name="items[{{ $i }}][cantidad]" min="0" step="1"
                       class="border rounded px-2 py-1 w-24 text-right"
                       value="{{ $cant }}">
              </td>
            </tr>
          @empty
            <tr><td colspan="3" class="py-6 text-center text-gray-600">No hay productos disponibles.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Datos del pedido (UID) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <div>
        <label for="fecha_entrega" class="block text-sm text-gray-600 mb-1">Fecha de entrega</label>
        <input type="date" name="fecha_entrega" id="fecha_entrega"
               class="w-full border rounded px-3 py-2"
               value="{{ old('fecha_entrega') }}">
        @error('fecha_entrega')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
      </div>

      <div>
        <label for="hora_entrega" class="block text-sm text-gray-600 mb-1">Hora de entrega</label>
        <input type="time" name="hora_entrega" id="hora_entrega"
               class="w-full border rounded px-3 py-2"
               value="{{ old('hora_entrega') }}">
        @error('hora_entrega')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
      </div>



      <div>
        <label for="tipo_retiro" class="block text-sm text-gray-600 mb-1">Tipo de retiro (opcional)</label>
        <select name="tipo_retiro" id="tipo_retiro" class="w-full border rounded px-3 py-2">
          <option value="">-- seleccionar --</option>
          <option value="retiro" {{ old('tipo_retiro')==='retiro' ? 'selected' : '' }}>Retiro</option>
          <option value="envio"  {{ old('tipo_retiro')==='envio'  ? 'selected' : '' }}>Envío</option>
        </select>
        @error('tipo_retiro')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
      </div>

      <div>
        <label for="forma_pago" class="block text-sm text-gray-600 mb-1">Forma de pago (opcional)</label>
        <input type="text" name="forma_pago" id="forma_pago"
               class="w-full border rounded px-3 py-2"
               placeholder="Efectivo / Transferencia / ... "
               value="{{ old('forma_pago') }}">
        @error('forma_pago')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
      </div>

      <div class="md:col-span-2">
        <label for="personalizacion" class="block text-sm text-gray-600 mb-1">Personalización (opcional)</label>
        <textarea name="personalizacion" id="personalizacion" rows="3"
                  class="w-full border rounded px-3 py-2"
                  placeholder="Texto, colores, referencias...">{{ old('personalizacion') }}</textarea>
        @error('personalizacion')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="flex items-center gap-2">
      <button type="submit" class="border px-4 py-2 rounded">Confirmar pedido</button>
      <a href="{{ url()->previous() }}" class="px-4 py-2">Cancelar</a>
    </div>
  </form>
</div>

{{-- Script opcional: min hoy + bloqueo por NoDisponibilidad (sin librerías) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  var input = document.getElementById('fecha_entrega');
  if (!input) return;

  // min a hoy
  var hoy = new Date().toISOString().split('T')[0];
  input.setAttribute('min', hoy);

  // Bloqueo liviano con fetch (si agregaste la ruta fechas.bloqueadas)
  fetch('{{ route('fechas.bloqueadas') }}')
    .then(r => r.json())
    .then(fechas => {
      input.addEventListener('input', function() {
        if (fechas.includes(this.value)) {
          alert('La fecha seleccionada no está disponible. Por favor, elegí otra.');
          this.value = '';
        }
      });
    })
    .catch(() => {/* silenciar */});
});
</script>
@endsection
