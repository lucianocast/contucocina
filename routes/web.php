<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Cliente\CatalogoController;
use App\Http\Controllers\Cliente\PedidoController as ClientePedidoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\RecetaController;
use App\Http\Controllers\Admin\PedidoRecibidoController;

// Página inicial y catálogo
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');

// Rutas de autenticación Breeze
require __DIR__.'/auth.php';

// 🟢 CLIENTE
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/pedido', [ClientePedidoController::class, 'create'])->name('cliente.pedido');
    Route::post('/pedido', [ClientePedidoController::class, 'store'])->name('pedido.guardar');

    Route::get('/historial', [ClientePedidoController::class, 'historial'])->name('cliente.historial');

    Route::get('/pedido/{id}/cancelar', [ClientePedidoController::class, 'confirmarCancelacion'])->name('pedido.confirmar_cancelacion');
    Route::put('/pedido/{id}/cancelar', [ClientePedidoController::class, 'cancelar'])->name('pedido.cancelar');
    Route::get('/fechas-no-disponibles', function () {
    return NoDisponibilidad::pluck('fecha')
        ->map(fn($d) => $d->format('Y-m-d'))
        ->values();
})->name('fechas.bloqueadas');
});

// 🔴 ADMINISTRADOR
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    // ABM de productos
    Route::resource('/productos', ProductoController::class);

    // ABM de recetas
    Route::resource('/recetas', RecetaController::class);

    // Gestión de pedidos recibidos
    Route::get('/admin/pedidos', [PedidoRecibidoController::class, 'index'])->name('pedidos.recibidos');
    Route::put('/admin/pedidos/{id}/estado', [PedidoRecibidoController::class, 'actualizarEstado'])->name('pedidos.cambiar_estado');
    
    // Gestión de reportes
    Route::get('/admin/reportes', [\App\Http\Controllers\Admin\ReporteController::class, 'index'])
    ->name('admin.reportes')
    ->middleware(['auth', 'role:admin']);
    
    // Gestión de combos
    Route::resource('admin/combos', \App\Http\Controllers\Admin\ComboController::class);
    // Gestión de fechas no disponibles
    Route::resource('/admin/no-disponibles', \App\Http\Controllers\Admin\NoDisponibilidadController::class)
        ->except(['show'])
        ->names('no-disponibles');
    
    //Gestión de recetarios
    Route::get('/admin/recetario', [\App\Http\Controllers\Admin\RecetarioController::class,'index'])->name('recetario.index');
    Route::post('/admin/recetario', [\App\Http\Controllers\Admin\RecetarioController::class,'store'])->name('recetario.store');
    Route::get('/admin/recetario/{id}/descargar', [\App\Http\Controllers\Admin\RecetarioController::class,'download'])->name('recetario.download');
    Route::delete('/admin/recetario/{id}', [\App\Http\Controllers\Admin\RecetarioController::class,'destroy'])->name('recetario.destroy');
    
    // Gestión de Usuarios
    Route::resource('/admin/usuarios', \App\Http\Controllers\Admin\UserController::class)
        ->parameters(['usuarios' => 'usuario'])
        ->except(['show'])
        ->names('usuarios');

    // Activar/Desactivar
    Route::patch('/admin/usuarios/{usuario}/toggle', [\App\Http\Controllers\Admin\UserController::class,'toggle'])
        ->name('usuarios.toggle');
});
