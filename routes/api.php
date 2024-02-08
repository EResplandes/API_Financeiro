<?php

use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\UnidadeConsumidoraController;
use App\Models\UnidadeConsumidora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {

    Route::prefix('autenticacao')->group(function () {
        Route::post('/login', [AutenticacaoController::class, 'login']);
        Route::post('/logout', [AutenticacaoController::class, 'logout']);
    });

    // Rotas de Unidade Consumidora
    Route::prefix('unidades')->middleware('jwt.auth')->group(function () {
        Route::get('/listar', [UnidadeConsumidoraController::class, 'listarUnidades']);
        Route::post('/cadastrar', [UnidadeConsumidoraController::class, 'cadastrarUnidade']);
        Route::put('/editar/{id?}', [UnidadeConsumidoraController::class, 'editarUnidade'])->middleware('validate.id');
        Route::get('/busca/{id?}', [UnidadeConsumidoraController::class, 'buscaUnidade'])->middleware('validate.id');
    });
});
