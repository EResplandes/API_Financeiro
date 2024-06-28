<?php

use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ParcelaController;
use App\Http\Controllers\UnidadeConsumidoraController;
use App\Models\Parcela;
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

    // Rotas de Autenticação
    Route::prefix('autenticacao')->group(function () {
        Route::post('/login', [AutenticacaoController::class, 'login']);
        Route::post('/logout', [AutenticacaoController::class, 'logout']);
    });

    // Rotas de Unidade Consumidora
    Route::prefix('unidades')->middleware('jwt.auth')->group(function () {
        Route::get('/listar', [UnidadeConsumidoraController::class, 'listarUnidades']);
        Route::get('/listar-filtros', [UnidadeConsumidoraController::class, 'listarUnidadesFiltros']);
        Route::post('/cadastrar', [UnidadeConsumidoraController::class, 'cadastrarUnidade']);
        Route::put('/editar/{id?}', [UnidadeConsumidoraController::class, 'editarUnidade'])->middleware('validate.id');
        Route::get('/busca/{id?}', [UnidadeConsumidoraController::class, 'buscaUnidade'])->middleware('validate.id');
    });

    // Rotas de Empresas
    Route::prefix('empresas')->middleware('jwt.auth')->group(function () {
        Route::get('/listar', [EmpresaController::class, 'listarEmpresas']);
        Route::get('/listar-filtros', [EmpresaController::class, 'listarEmpresasFiltros']);
        Route::post('/cadastrar', [EmpresaController::class, 'cadastrarEmpresa']);
        Route::put('/editar/{id?}', [EmpresaController::class, 'editarEmpresa'])->middleware('validate.id');
        Route::get('/busca/{id?}', [EmpresaController::class, 'buscaEmpresa'])->middleware('validate.id');
    });

    // Rotas de Fornecedores
    Route::prefix('fornecedores')->middleware('jwt.auth')->group(function () {
        Route::get('/listar', [FornecedorController::class, 'listarFornecedores']);
        Route::get('/listar-filtros', [FornecedorController::class, 'listarForncedoresFiltros']);
        Route::post('/cadastrar', [FornecedorController::class, 'cadastrarFornecedor']);
        Route::put('/editar/{id?}', [FornecedorController::class, 'editarFornecedor'])->middleware('validate.id');
    });

    // Rotas de Contratos
    Route::prefix('contratos')->middleware('jwt.auth')->group(function () {
        Route::get('/listar', [ContratoController::class, 'listarContratos']);
        Route::get('/listar-filtros', [ContratoController::class, 'listarContratosFiltros']);
        Route::post('/cadastrar', [ContratoController::class, 'cadastrarContrato']);
        Route::get('/busca/{id?}', [ContratoController::class, 'buscaContrato'])->middleware('validate.id');
    });

    // Rotas das Parcelas
    Route::prefix('parcelas')->middleware('jwt.auth')->group(function () {
        Route::get('/listar/{id}', [ParcelaController::class, 'listarParcelas'])->middleware('validate.id');
        Route::post('/cadastrar', [ParcelaController::class, 'cadastrarParcela']);
        Route::delete('/deletar/{id}', [ParcelaController::class, 'excluirParcela'])->middleware('validate.id');
        Route::get('/status-link/{id}/{idPedido}', [ParcelaController::class, 'statusLink']);
        Route::get('/aprova-parcela/{id}', [ParcelaController::class, 'aprovaParcela'])->middleware('validate.id');
        Route::get('/reprova-parcela/{id}', [ParcelaController::class, 'reprovaParcela'])->middleware('validate.id');
        Route::post('/anexar-comprovante', [ParcelaController::class, 'anexarComprovante']);
    });

    // Rotas do Dashboard
    Route::prefix('dashboard')->middleware('jwt.auth')->group(function () {
        Route::get('/listar-informacoes', [DashboardController::class, 'listarInformacoes']);
    });

});
