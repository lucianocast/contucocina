<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contucocina</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        header, footer { background-color: #f8f8f8; padding: 1rem; text-align: center; }
        nav a { margin: 0 10px; text-decoration: none; color: #333; }
        .contenido { padding: 2rem; text-align: center; }
        .grid { display: flex; justify-content: center; gap: 2rem; margin-top: 2rem; }
        .grid div { border: 1px solid #ccc; padding: 2rem; width: 200px; }
        .producto-img {
            max-width: 180px;
            max-height: 180px;
            width: auto;
            height: auto;
            display: block;
            margin: 0 auto 1rem auto;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Contucocina</h1>
        <nav>
            <a href="{{ url('/') }}">Inicio</a>
            <a href="#">Quiénes Somos</a>
            <a href="{{ route('catalogo') }}">Catálogo</a>
            <a href="{{ route('register') }}">Registrate</a>
            <a href="{{ route('login') }}">Login</a>
        </nav>
    </header>

    <div class="contenido">
        <h2 class="text-xl font-bold mb-4">Destacado</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse ($destacados as $producto)
        <div class="border p-4 rounded shadow">
            @if ($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}" class="producto-img">
            @endif
            <h3 class="font-bold">{{ $producto->nombre }}</h3>
            <p>{{ $producto->descripcion }}</p>
            <p class="text-green-600 font-semibold">${{ number_format($producto->precio, 0, ',', '.') }}</p>
        </div>
    @empty
        <p>No hay productos destacados.</p>
    @endforelse
</div>
        <div class="grid">
            <h2 class="text-xl font-bold mt-8 mb-4">Ofertas</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse ($ofertas as $producto)
        <div class="border p-4 rounded shadow">
            @if ($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}" class="producto-img">
            @endif
            <h3 class="font-bold">{{ $producto->nombre }}</h3>
            <p>{{ $producto->descripcion }}</p>
            <p class="text-red-600 font-semibold">${{ number_format($producto->precio, 0, ',', '.') }}</p>
        </div>
    @empty
        <p>No hay ofertas disponibles.</p>
    @endforelse
</div>
           <h2 class="text-xl font-bold mt-8 mb-4">Populares</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse ($populares as $producto)
        <div class="border p-4 rounded shadow">
            @if ($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}" class="producto-img">
            @endif
            <h3 class="font-bold">{{ $producto->nombre }}</h3>
            <p>{{ $producto->descripcion }}</p>
            <p class="text-blue-600 font-semibold">${{ number_format($producto->precio, 0, ',', '.') }}</p>
        </div>
    @empty
        <p>No hay productos populares.</p>
    @endforelse
</div>
        </div>
    </div>

    <footer>
        <a href="#">Políticas de privacidad</a> |
        <a href="#">Sobre Contucocina</a>
    </footer>
</body>
</html>
