<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\IncidenciaTecnicoController;
use App\Http\Controllers\MantenimientoTecnicoController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CategoriaController::class)->group(function () {
    Route::get('/categorias', 'index')->middleware('auth:api','admin');
    Route::post('/categorias', 'store')->middleware('auth:api','admin');
    //Route::get('/categorias/{id}', 'show')->middleware('auth:api','admin');
    Route::put('/categorias/{id}', 'update')->middleware('auth:api','admin');
    //Route::delete('/categorias/{id}', 'destroy')->middleware('auth:api','admin');
    Route::put('/categorias/{id}/enable',  'enable')->middleware('auth:api','admin');
    Route::put('/categorias/{id}/disable',  'disable')->middleware('auth:api','admin');
    Route::get('categorias/prioridad', 'getIncidenciasPorPrioridad');
});

Route::controller(MaquinaController::class)->group(function () {
    Route::get('/maquinas', 'index')->middleware('auth:api', 'admin');
    Route::post('/maquinas', 'store')->middleware('auth:api', 'admin');
    Route::get('/maquinasCount', 'countMaquinas')->middleware('auth:api', 'admin');
    Route::get('/maquinasTD', 'getMaquinasTD')->middleware('auth:api', 'admin');
    Route::put('/maquinas/{id}/enable', 'enable')->middleware('auth:api', 'admin');
    Route::put('/maquinas/{id}/disable', 'disable')->middleware('auth:api', 'admin');
    Route::put('/maquinas/{id}','update')->middleware('auth:api', 'admin');
    Route::get('/maquinas/{id}/estados', 'estdoMaquinaPorId');
});

Route::controller(MantenimientoController::class)->group(function () {
    Route::get('/mantenimientos', 'index');
    Route::post('/mantenimientosCreate', 'store')->middleware('auth:api');
    Route::get('/mantenimientos/{id}', 'show')->middleware('auth:api');
    Route::put('/mantenimientos/{id}', 'update')->middleware('auth:api', 'tecnico');
    Route::put('/mantenimientos/{id}/comentario', 'actualizarComentario')->middleware('auth:api', 'tecnico');
    Route::get('/mantenimientos/{id}/comentario', 'obtenerComentario')->middleware('auth:api');
    Route::get('/mantenimientosCount', 'countMantenimiento')->middleware('auth:api');
    Route::put('/mantenimientos/{id}/resuelto', 'marcarMantenimientoComoResuelta')->middleware('auth:api');
});

Route::controller(CampusController::class)->group(function () {
    Route::get('/campus', 'index')->middleware('auth:api', 'admin');
    Route::post('/campus', 'store')->middleware('auth:api', 'admin');
    Route::get('/campus/{campus}', 'show')->middleware('auth:api', 'admin');
    Route::put('/campus/{campus}', 'update')->middleware('auth:api', 'admin');
    Route::put('/campus/{campus}/enable', 'enable')->middleware('auth:api', 'admin');
    Route::put('/campus/{campus}/disable', 'disable')->middleware('auth:api', 'admin');
});

Route::controller(SectionController::class)->group(function () {
    Route::get('/secciones', 'index');
    Route::post('/secciones', 'store');
    Route::get('/secciones/{seccion}', 'show');
    Route::put('/secciones/{seccion}', 'update');
    Route::put('/secciones/{seccion}/disable', 'disable');
    Route::get('/sectionByCampus/{campus}', 'getSectionsByCampus');
    Route::get('/seccionesConCampus', 'getSectionsWithCampus');
});

Route::controller(IncidenciaController::class)->group(function () {
    Route::get('/incidencias', 'index')->middleware('auth:api');
    Route::post('/incidencias', 'store')->middleware('auth:api');
    Route::get('/incidencias/latest', 'getUltimasIncidenciasPorPrioridad')->middleware('auth:api');
    Route::get('/incidencias/prioridad', 'countIncidenciasPorPrioridad')->middleware('auth:api');
    Route::get('/incidencias/campus/{campus}', 'getIncidenciasByCampus')->middleware('auth:api');
    Route::get('/incidencias/section/{section}', 'getIncidenciasBySection')->middleware('auth:api');
    Route::get('/incidencias/{id}', 'show')->middleware('auth:api');
    Route::put('/incidencias/{id}/resuelta', 'marcarIncidenciaComoResuelta')->middleware('auth:api');
    Route::put('/incidencias/{id}/comentario', 'actualizarComentario')->middleware('auth:api', 'tecnico');
    Route::get('/incidencias/{id}/comentario', 'obtenerComentario')->middleware('auth:api');
    Route::get('/incidenciasCount', 'countIncidenciasEstados')->middleware('auth:api');
    Route::get('incidencias/latest', 'getUltimasIncidenciasPorPrioridad');
});

Route::get('/roles', [RolController::class, 'index']);

Route::controller(AuthController::class)->prefix('auth')->group(function()  {
    Route::post('login', 'login');
    Route::post('register', 'register')->middleware('auth:api', 'admin');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('me', 'me')->middleware('auth:api');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->middleware('auth:api', 'admin');
    Route::get('/usersCount', 'countUsers')->middleware('auth:api', 'admin');
    Route::post('/store', 'store')->middleware('auth:api', 'admin');
    Route::put('/users/{id}', 'update')->middleware('auth:api', 'admin');
    Route::put('/users/{id}/enable', 'enable')->middleware('auth:api', 'admin');
    Route::put('/users/{id}/disable', 'disable')->middleware('auth:api', 'admin');
});

Route::controller(IncidenciaTecnicoController::class)->group(function () {
    Route::post('/timer', 'store');
    Route::put('/timer/{id}', 'update');
    Route::get('/timer/latest', 'getLatestIncidenciaTecnico');
    Route::get('/timer/{id}/tiempototal', 'calcularTiempoTrabajado');
    Route::get('/incidencias/{id}/estado', 'obtenerEstadoIncidencia');
});

Route::controller(MantenimientoTecnicoController::class)->group(function () {
    Route::post('/mantenimiento/timer', 'store');
    Route::put('/mantenimiento/timer/{id}', 'update');
    Route::get('/mantenimiento/timer/latest', 'getLatestMantenimientoTecnico');
    Route::get('/mantenimiento/timer/{id}/tiempototal', 'calcularTiempoTrabajado');
});
