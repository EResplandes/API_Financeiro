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

    public function excluirParcela($id)
    {
        $query = $this->parcelaService->excluir($id); // Metódo responsável por excluir parcela
        return response()->json(['resposta' => $query['mensagem']], $query['status']);
    }

    public function statusLink($id, $idPedido)
    {
        $query = $this->parcelaService->statusLink($id, $idPedido); // Metódo responsável por atualizar status para 'Em Aprovação'
        return response()->json(['resposta' => $query['resposta']], $query['status']);
    }

    public function aprovaParcela($id)
    {
        $query = $this->parcelaService->aprovaParcela($id); // Metódo responsável por atualizar status da parcela
        return response()->json(['resposta' => $query['resposta']], $query['status']);
    }

    public function reprovaParcela($id)
    {
        $query = $this->parcelaService->reprovaParcela($id); // Metódo responsável por reprovar status da parcela
        return response()->json(['resposta' => $query['resposta']], $query['status']);
    }

    public function anexarComprovante(Request $request)
    {
        $query = $this->parcelaService->anexarComprovante($request); // Metódo responsável por cadastrar comprovante
        return response()->json(['resposta' => $query['resposta']], $query['status']);
    }
}
