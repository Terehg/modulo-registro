<?php


use App\Http\Controllers\API\TurnoController;
use App\Http\Controllers\API\RegistroController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|
*/

// Son las rutas del back
Route::apiResource('turnos',TurnoController::class);
Route::apiResource('registros',RegistroController ::class);
