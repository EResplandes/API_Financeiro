<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContratoService;

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

    public function cadastrarContrato(Request $request)
    {
        $query = $this->contratoService->cadastrar($request); // Método responsável por cadastrar um novo contrato
        return response()->json(['mensagem' => $query['mensagem']], $query['status']);
    }
}
