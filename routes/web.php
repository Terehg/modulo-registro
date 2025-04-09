<?php

use App\Http\Controllers\RegistrosController;
use App\Http\Controllers\TurnosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/registros');
});

Route::get('/turnos', [TurnosController::class, 'index'])->name('turnos.index');
Route::get('/registros', [RegistrosController::class, 'index'])->name('registros.index');
