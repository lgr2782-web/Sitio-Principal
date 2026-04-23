<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth.api')
    ->name('dashboard');

Route::get('/usuarios', [UsuarioController::class,'index'])
    ->middleware('auth.api')
    ->name('usuarios');

Route::post('/usuarios', [UsuarioController::class,'store'])
    ->middleware('auth.api')
    ->name('usuarios.store');

Route::put('/usuarios/{id}/desactivar', [UsuarioController::class,'desactivar'])
    ->middleware('auth.api')
    ->name('usuarios.desactivar');
    
    Route::put('/usuarios/{id}', [UsuarioController::class,'update'])
    ->middleware('auth.api')
    ->name('usuarios.update');

Route::get('/empresa', function () {
    return view('empresa.index');
})->name('empresa');

Route::get('/empresas', function () {
    return view('empresa.listado');
})->name('empresas');



Route::get('/productos', [ProductoController::class, 'index'])
    ->middleware('auth.api')
    ->name('productos');

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes');

Route::get('/inventario', [InventarioController::class, 'index'])
    ->middleware('auth.api')
    ->name('inventario');