<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ParcelaService;
use App\Http\Requests\ParcelaRequest;

class ParcelaController extends Controller
{

    protected $parcelaService;

    public function __construct(ParcelaService $parcelaService)
    {
        $this->parcelaService = $parcelaService;
    }

    public function listarParcelas($id)
    {
        $query = $this->parcelaService->listar($id); // Metódo responsável por listar parcelas através do id do contrato
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }

    public function cadastrarParcela(ParcelaRequest $request)
    {
        $query = $this->parcelaService->cadastrar($request); // Metóto responsável por cadastrar parcela
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }

    public function enviaDiretoria($id)
    {
        $query = $this->parcelaService->diretoria($id); // Metódo responsável por alterar status para enviado para diretoria
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }

    public function enviaPresidencia($id)
    {
        $query = $this->parcelaService->presidencia($id); // Metódo responsável por alterar status para enviado para diretoria
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }
}
