@csrf
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <div>
    <label class="block text-sm text-gray-600 mb-1">Fecha</label>
    <input type="date" name="fecha" class="w-full border rounded px-3 py-2"
           value="{{ old('fecha', isset($no_disponible) ? $no_disponible->fecha?->format('Y-m-d') : '') }}"
           required>
    @error('fecha')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm text-gray-600 mb-1">Motivo (opcional)</label>
    <input type="text" name="motivo" class="w-full border rounded px-3 py-2"
           placeholder="Vacaciones, evento, mantenimiento…"
           value="{{ old('motivo', $no_disponible->motivo ?? '') }}">
    @error('motivo')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
</div>

<div class="mt-4 flex items-center gap-2">
  <button type="submit" class="border px-4 py-2 rounded">
    {{ isset($no_disponible) ? 'Actualizar' : 'Guardar' }}
  </button>
  <a href="{{ route('no-disponibles.index') }}" class="px-4 py-2">Cancelar</a>
</div>
