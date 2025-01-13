<?php

use App\Http\Controllers\AuthController;
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

Route::get('/roles', [RolController::class, 'index']);

Route::controller(AuthController::class)->prefix('auth')->group(function()  {
    Route::post('login', 'login');
    Route::post('register', 'register')->middleware('auth:api', 'admin');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('me', 'me')->middleware('auth:api');
});

//Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//    Route::get('/admin/users', [UserController::class, 'index']);
//    Route::post('/admin/users', [UserController::class, 'store']);
//    // Otras rutas de administrador
//});
