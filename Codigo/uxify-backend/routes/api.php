<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MaquinaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});

Route::controller(CategoriaController::class)->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index']);
});

Route::controller(MaquinaController::class)->group(function () {
    Route::get('/maquinas', [MaquinaController::class, 'index']);
});

Route::controller(CampusController::class)->group(function () {
    Route::get('/campus', [CampusController::class, 'index']);
});

Route::controller(IncidenciaController::class)->group(function () {
    Route::get('/incidencias', [IncidenciaController::class, 'index']);
});

Route::get('/roles', [RolController::class, 'index']);

Route::get('categorias/prioridad', [CategoriaController::class, 'getIncidenciasPorPrioridad']);

Route::get('incidencias/latest', [IncidenciaController::class, 'getUltimasIncidenciasPorPrioridad']);

Route::controller(AuthController::class)->prefix('auth')->group(function()  {
    Route::post('login', 'login');
    Route::post('register', 'register')->middleware('auth:api', 'admin');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('me', 'me')->middleware('auth:api');
});

Route::post('/store', [UserController::class, 'store']);

//Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//    Route::get('/admin/users', [UserController::class, 'index']);
//    Route::post('/admin/users', [UserController::class, 'store']);
//    // Otras rutas de administrador
//});
