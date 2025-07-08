<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - ContuCocina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN (reemplazar por Vite si se compila localmente) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- HEADER -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-pink-600">ContuCocina</a>

            <nav class="space-x-4 text-sm">
                @auth
                    @if (auth()->user()->rol === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hover:underline">Panel</a>
                        <a href="{{ route('productos.index') }}" class="hover:underline">Productos</a>
                        <a href="{{ route('recetas.index') }}" class="hover:underline">Recetas</a>
                        <a href="{{ route('pedidos.recibidos') }}" class="hover:underline">Pedidos</a>
                    @else
                        <a href="{{ route('catalogo') }}" class="hover:underline">Catálogo</a>
                        <a href="{{ route('cliente.pedido') }}" class="hover:underline">Realizar Pedido</a>
                        <a href="{{ route('cliente.historial') }}" class="hover:underline">Mis Pedidos</a>
                    @endif
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-red-600 hover:underline">Cerrar sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                @else
                    <a href="{{ route('catalogo') }}" class="hover:underline">Catálogo</a>
                    <a href="{{ route('login') }}" class="hover:underline">Ingresar</a>
                    <a href="{{ route('register') }}" class="hover:underline">Registrarse</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- CONTENIDO -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white text-center text-sm text-gray-500 py-4 mt-10 border-t">
        © {{ date('Y') }} ContuCocina - Todos los derechos reservados.
    </footer>

</body>
</html>
