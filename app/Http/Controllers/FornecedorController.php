<?php

namespace App\Http\Controllers;

use App\Services\FornecedorService;
use Illuminate\Http\Request;
use App\Http\Requests\FornecedoresRequest;

class FornecedorController extends Controller
{

    protected $fornecedorService;

    public function __construct(FornecedorService $fornecedorService)
    {
        $this->fornecedorService = $fornecedorService;
    }

    public function listarFornecedores()
    {
        $query = $this->fornecedorService->listar(); // Metódo responsável por buscar todos fornecedores
        return response()->json(['response' => $query['mensagem']], $query['status']); // Retornando resposta
    }

    public function listarForncedoresFiltros(Request $request)
    {
        $query = $this->fornecedorService->listarFiltros($request); // Metódo responsável por buscar com filtros
        return response()->json(['response' => $query['mensagem']], $query['status']); // Retornando resposta
    }

    public function cadastrarFornecedor(FornecedoresRequest $request)
    {
        $query = $this->fornecedorService->cadastro($request); // Metódo responsável por cadastrar fornecedor
        return response()->json(['response' => $query['mensagem']], $query['status']); // Retornando resposta
    }

    public function editarFornecedor(Request $request, $id)
    {
        $query = $this->fornecedorService->editar($request, $id); // Metódo responsável por editar fornecedor
        return response()->json(['response' => $query['mensagem']], $query['status']); // Retornando resposta
    }
}
