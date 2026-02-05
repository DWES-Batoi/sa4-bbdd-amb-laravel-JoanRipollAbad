<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JugadoraController;
use App\Http\Controllers\Api\EquipController;
use App\Http\Controllers\Api\EstadiController;
use App\Http\Controllers\Api\AuthController;

// Rutes públiques
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::apiResource('jugadores', JugadoraController::class)
    ->parameters(['jugadores' => 'jugadora'])
    ->only(['index', 'show']);

Route::apiResource('equipos', EquipController::class)
    ->parameters(['equipos' => 'equip'])
    ->only(['index', 'show']);

Route::apiResource('estadios', EstadiController::class)
    ->parameters(['estadios' => 'estadi'])
    ->only(['index', 'show']);

// Rutes protegides
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::apiResource('jugadores', JugadoraController::class)
        ->parameters(['jugadores' => 'jugadora'])
        ->except(['index', 'show']);
        
    Route::apiResource('equipos', EquipController::class)
        ->parameters(['equipos' => 'equip'])
        ->except(['index', 'show']);
        
    Route::apiResource('estadios', EstadiController::class)
        ->parameters(['estadios' => 'estadi'])
        ->except(['index', 'show']);
});