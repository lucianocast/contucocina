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
        <div style="border: 1px solid #ccc; padding: 2rem; margin-bottom: 2rem;">
            <h2>Destacado</h2>
        </div>
        <div class="grid">
            <div><h3>Ofertas</h3></div>
            <div><h3>Populares</h3></div>
        </div>
    </div>

    <footer>
        <a href="#">Políticas de privacidad</a> |
        <a href="#">Sobre Contucocina</a>
    </footer>
</body>
</html>
