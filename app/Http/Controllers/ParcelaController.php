<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ParcelaService;

class ParcelaController extends Controller
{

    protected $parcelaService;

    public function __construct(ParcelaService $parcelaService)
    {
        $this->parcelaService = $parcelaService;
    }

    public function listarParcelas($id)
    {
        $query = $this->parcelaService->listar($id); // Metódo responsável 
        return response()->json(['response' => $query['mensagem']], $query['status']);
    }
}
