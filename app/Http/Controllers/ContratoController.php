<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContratoService;
use App\Http\Requests\ContratoRequest;

class ContratoController extends Controller
{

    protected $contratoService;

    public function __construct(ContratoService $contratoService)
    {
        $this->contratoService = $contratoService;
    }

    public function listarContratos()
    {
        $query = $this->contratoService->listar(); // Método responsável por listar todos contratos
        return response()->json(['mensagem' => $query['mensagem']], $query['status']);
    }

    public function listarContratosFiltros(Request $request)
    {
        $query = $this->contratoService->listarFiltros($request); // Método responsável por listar contratos de acordo com filtro
        return response()->json(['mensagem' => $query['mensagem']], $query['status']);
    }

    public function cadastrarContrato(ContratoRequest $request)
    {
        $query = $this->contratoService->cadastrar($request); // Método responsável por cadastrar um novo contrato
        return response()->json(['mensagem' => $query['mensagem']], $query['status']);
    }

    public function editarContrato(Request $request)
    {
        $query = $this->contratoService->editar(); // Método responsável por editar contrato
        return response()->json(['mensagem' => $query['mensagem']], $query['status']);
    }

    public function buscaContrato()
    {
        $query = $this->contratoService->busca(); // Método resposável por buscar dados de um contrato
        return response()->json(['mensagem' => $query['mensagem']], $query['status']);
    }
}
