<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutenticacaoRequest;
use App\Services\AutenticacaoService;
use Illuminate\Http\Request;

class AutenticacaoController extends Controller
{

    protected $autenticacaoService;

    public function __construct(AutenticacaoService $autenticacaoService)
    {
        $this->autenticacaoService = $autenticacaoService;
    }


    public function login(AutenticacaoRequest $request)
    {

        $query = $this->autenticacaoService->login($request); // Consulta para realizar autenticação
        return response()->json(['Response' => $query]); // Retornando resposta

    }

    public function logout(Request $request)
    {

        $query = $this->autenticacaoService->logout($request); // Consulta para realizar invalidação do token
        return response()->json(['Response' => 'Usuário deslogado com sucesso!']); // Retornando resposta

    }

    public function check(Request $request)
    {

        $query = $this->autenticacaoService->checkToken($request); // Consulta para verificar se token está valido
        return response()->json(['Response' => $query]); // Retornando resposta

    }

    public function first(Request $request)
    {

        $query = $this->autenticacaoService->firstAccess($request); // Consulta para alterar status do primeiro acesso como false
        return response()->json(['Response' => $query]); // Retornando respsota

    }
}
