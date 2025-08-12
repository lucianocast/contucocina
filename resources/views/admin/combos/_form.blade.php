@php
  // Para edit: $pivot es un mapa producto_id => cantidad
  $pivot = isset($pivot) ? collect($pivot) : collect();
  @endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <div>
    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
    <input type="text" name="nombre" class="w-full border rounded px-3 py-2"
           value="{{ old('nombre', $combo->nombre ?? '') }}" required>
    @error('nombre')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">Precio del combo</label>
    <input type="number" step="0.01" min="0" name="precio_combo" class="w-full border rounded px-3 py-2"
           value="{{ old('precio_combo', $combo->precio_combo ?? '') }}" required>
    @error('precio_combo')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="flex items-end">
    <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="activo" value="1"
             {{ old('activo', ($combo->activo ?? true)) ? 'checked' : '' }}>
      Activo
    </label>
  </div>
</div>

<div class="border rounded">
  <div class="px-4 py-3 border-b">
    <h3 class="text-lg font-semibold">Productos del combo</h3>
    <p class="text-sm text-gray-600">Seleccioná los productos y definí la cantidad de cada uno.</p>
  </div>

  <div class="p-4 overflow-x-auto">
    @error('productos')<div class="text-red-600 text-sm mb-2">{{ $message }}</div>@enderror
    @error('cantidades')<div class="text-red-600 text-sm mb-2">{{ $message }}</div>@enderror

    <table class="min-w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2 pr-2">Producto</th>
          <th class="text-left py-2 pr-2">Precio</th>
          <th class="text-center py-2 pr-2">Incluir</th>
          <th class="text-right py-2 pr-2">Cantidad</th>
        </tr>
      </thead>
      <tbody>
        @foreach($productos as $p)
          @php
            $checked = false;
            $cantidad = 1;
            // Para edit: si el producto está en el pivot, marcar y cargar cantidad
            if ($pivot && $pivot->has($p->id)) {
              $checked = true;
              $cantidad = (int) $pivot->get($p->id);
            }
            // Para create + postback: si viene en old()
            $oldProductos = collect(old('productos', []));
            $oldCantidades = collect(old('cantidades', []));
            if ($oldProductos->isNotEmpty()) {
              // Buscar este id en old productos
              foreach ($oldProductos as $idx => $prodId) {
                if ((int)$prodId === (int)$p->id) {
                  $checked = true;
                  $cantidad = max(1, (int)($oldCantidades[$idx] ?? 1));
                }
              }
            }
          @endphp
          <tr class="border-b">
            <td class="py-2 pr-2">{{ $p->nombre }}</td>
            <td class="py-2 pr-2">$ {{ number_format($p->precio,2,',','.') }}</td>
            <td class="py-2 pr-2 text-center">
              <input type="checkbox" name="productos[]" value="{{ $p->id }}" {{ $checked ? 'checked' : '' }}>
            </td>
            <td class="py-2 pr-2 text-right">
              <input type="number" name="cantidades[]" min="1" step="1"
                     class="border rounded px-2 py-1 w-24 text-right"
                     value="{{ $cantidad }}">
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
