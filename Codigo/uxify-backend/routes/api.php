<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'userProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/users', [UserController::class, 'index']);

Route::middleware(['auth:api', 'checkrole:admin'])->group(function () {
    Route::get('/admin/dashboard', function(){
        return response()->json(['message' => 'Admin dashboard']);
    });
});
Route::middleware(['auth:api', 'checkrole:user,admin'])->group(function () {
    Route::get('/user/dashboard', function(){
        return response()->json(['message' => 'User dashboard']);
    });
});
