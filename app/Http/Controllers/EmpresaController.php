<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaRequest;
use App\Services\EmpresaService;
use App\Http\Requests\EmpresaUpdateRequest;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{

    protected $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    public function listarEmpresas()
    {
        $query = $this->empresaService->listarEmpresas(); // Busca todas empresas
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }

    public function listarEmpresasFiltros(Request $request)
    {
        $query = $this->empresaService->listarFiltros($request); // Busca com filtros
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }


    public function cadastrarEmpresa(EmpresaRequest $request)
    {
        $query = $this->empresaService->cadastrarEmpresa($request); // Cadastra empresa
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }

    public function editarEmpresa(EmpresaUpdateRequest $request, $id)
    {
        $query = $this->empresaService->editarEmpresa($request, $id); // Edita empresa de acordo com id
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }

    public function buscaEmpresa($id)
    {
        $query = $this->empresaService->buscaEmpresa($id); // Busca dados de empresa de acordo com id
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }
}
