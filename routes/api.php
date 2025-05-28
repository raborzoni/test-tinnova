<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VeiculoController;
use App\Http\Controllers\WebController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/veiculos/estatisticas/decadas', [VeiculoController::class, 'estatisticasPorDecada']);
    Route::get('/veiculos/estatisticas/fabricantes', [VeiculoController::class, 'estatisticasPorFabricante']);
    Route::get('/veiculos/ultima-semana', [VeiculoController::class, 'veiculosUltimaSemana']);
    Route::get('/veiculos/marcas-validas', [VeiculoController::class, 'marcasValidas']);

    Route::patch('/veiculos/{id}', [VeiculoController::class, 'patch']);

    Route::apiResource('veiculos', VeiculoController::class);
});

Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/veiculos', [WebController::class, 'veiculos'])->name('veiculos');
Route::get('/estatisticas', [WebController::class, 'estatisticas'])->name('estatisticas');
