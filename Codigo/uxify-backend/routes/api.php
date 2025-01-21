<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/usersCount', [UserController::class, 'countUsers']);
});

Route::controller(CategoriaController::class)->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index']);
});

Route::controller(MaquinaController::class)->group(function () {
    Route::get('/maquinas', [MaquinaController::class, 'index'])->middleware('auth:api', 'admin');
    Route::get('/maquinasCount', [MaquinaController::class, 'countMaquinas'])->middleware('auth:api', 'admin');
    Route::get('/maquinasTD', [MaquinaController::class, 'getMaquinasTD'])->middleware('auth:api', 'admin');
    Route::put('/maquinas/{id}/enable', [MaquinaController::class, 'enable'])->middleware('auth:api', 'admin');
    Route::put('/maquinas/{id}/disable', [MaquinaController::class, 'disable'])->middleware('auth:api', 'admin');
});

Route::controller(CampusController::class)->group(function () {
    Route::get('/campus', [CampusController::class, 'index']);
    Route::post('/campus', [CampusController::class, 'store']);
    Route::get('/campus/{campus}', [CampusController::class, 'show']);
    Route::put('/campus/{campus}', [CampusController::class, 'update']);
    Route::put('/campus/{campus}/disable', [CampusController::class, 'disable']);
});

Route::controller(SectionController::class)->group(function () {
    route::get('/secciones', [SectionController::class, 'index']);
    Route::post('/secciones', [SectionController::class, 'store']);
    Route::get('/secciones/{seccion}', [SectionController::class, 'show']);
    Route::put('/secciones/{seccion}', [SectionController::class, 'update']);
    Route::put('/secciones/{seccion}/disable', [SectionController::class, 'disable']);
    Route::get('/sectionByCampus/{campus}', [SectionController::class, 'getSectionsByCampus']);
});

Route::controller(IncidenciaController::class)->group(function () {
    Route::get('/incidencias', [IncidenciaController::class, 'index']);
    Route::post('/incidencias', [IncidenciaController::class, 'store']);
    Route::get('incidencias/latest', [IncidenciaController::class, 'getUltimasIncidenciasPorPrioridad']);
    Route::get('incidencias/prioridad', [IncidenciaController::class, 'countIncidenciasPorPrioridad']);
    Route::get('incidencias/campus/{campus}', [IncidenciaController::class, 'getIncidenciasByCampus']);
    Route::get('incidencias/section/{section}', [IncidenciaController::class, 'getIncidenciasBySection']);
    Route::get('/incidencias/{id}', [IncidenciaController::class, 'show'])->middleware('auth:api', 'admin');
});

Route::get('/roles', [RolController::class, 'index']);

Route::get('/seccionesConCampus', [SectionController::class, 'getSectionsWithCampus']);

Route::get('categorias/prioridad', [CategoriaController::class, 'getIncidenciasPorPrioridad']);

Route::get('incidencias/latest', [IncidenciaController::class, 'getUltimasIncidenciasPorPrioridad']);

Route::get('/maquinas/{id}/estados', [MaquinaController::class, 'estdoMaquinaPorId']);

Route::controller(AuthController::class)->prefix('auth')->group(function()  {
    Route::post('login', 'login');
    Route::post('register', 'register')->middleware('auth:api', 'admin');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('me', 'me')->middleware('auth:api');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/store', 'store')->middleware('auth:api', 'admin');
    Route::put('/users/{id}', 'update')->middleware('auth:api', 'admin');
    Route::put('/users/{id}/enable', [UserController::class, 'enable'])->middleware('auth:api', 'admin');
    Route::put('/users/{id}/disable', [UserController::class, 'disable'])->middleware('auth:api', 'admin');
});

//Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//    Route::get('/admin/users', [UserController::class, 'index']);
//    Route::post('/admin/users', [UserController::class, 'store']);
//    // Otras rutas de administrador
//});
