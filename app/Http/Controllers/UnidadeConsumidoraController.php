<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeConsumidoraRequest;
use Illuminate\Http\Request;
use App\Services\UnidadeConsumidoraService;

class UnidadeConsumidoraController extends Controller
{

    protected $unidadeService;

    public function __construct(UnidadeConsumidoraService $unidadeService)
    {
        $this->unidadeService = $unidadeService;
    }

    public function listarUnidades()
    {
        $query = $this->unidadeService->listarUnidades(); // Lista todas unidades consumidoras
        return response()->json(['response' => $query]);
    }

    public function cadastrarUnidade(UnidadeConsumidoraRequest $request)
    {
        $query = $this->unidadeService->cadastraUnidade($request); // Cadastra unidade consumidora
        return response()->json(['response' => $query]);
    }

    public function editarUnidade(UnidadeConsumidoraRequest $request, $id)
    {
        $query = $this->unidadeService->editarUnidade($request, $id); // Edita a unidade consumidora
        return response()->json(['response' => $query]);
    }

    public function buscaUnidade($id)
    {
        $query = $this->unidadeService->buscaUnidade($id); // Busca informações da unidade
        return response()->json(['response' => $query]);
    }
}
