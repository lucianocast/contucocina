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
});
