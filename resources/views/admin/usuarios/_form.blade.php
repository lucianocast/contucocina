@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
    <input type="text" name="name" class="w-full border rounded px-3 py-2"
           value="{{ old('name', $usuario->name ?? '') }}" required>
    @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">Correo</label>
    <input type="email" name="email" class="w-full border rounded px-3 py-2"
           value="{{ old('email', $usuario->email ?? '') }}" required>
    @error('email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">
      Contraseña {{ isset($usuario) ? '(dejar vacío para no cambiar)' : '' }}
    </label>
    <input type="password" name="password" class="w-full border rounded px-3 py-2"
           {{ isset($usuario) ? '' : 'required' }}>
    @error('password')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">Rol</label>
    <select name="rol" id="rol" class="w-full border rounded px-3 py-2">
      <option value="admin" {{ old('rol', $usuario->rol ?? '') == 'admin' ? 'selected' : '' }}>Administrador</option>
      <option value="cliente" {{ old('rol', $usuario->rol ?? '') == 'cliente' ? 'selected' : '' }}>Cliente</option>
    </select>
    @error('rol')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="md:col-span-2">
    <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="active" value="1"
             {{ old('active', $usuario->active ?? true) ? 'checked' : '' }}>
      Activo
    </label>
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">Teléfono</label>
    <input type="text" name="telefono" class="w-full border rounded px-3 py-2"
           value="{{ old('telefono', $usuario->telefono ?? '') }}">
    @error('telefono')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block text-sm text-gray-600 mb-1">Dirección</label>
    <input type="text" name="direccion" class="w-full border rounded px-3 py-2"
           value="{{ old('direccion', $usuario->direccion ?? '') }}">
    @error('direccion')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
  </div>
</div>

<div class="mt-4 flex items-center gap-2">
  <button type="submit" class="border px-4 py-2 rounded">
    {{ isset($usuario) ? 'Actualizar' : 'Crear' }}
  </button>
  <a href="{{ route('usuarios.index') }}" class="px-4 py-2">Cancelar</a>
</div>
