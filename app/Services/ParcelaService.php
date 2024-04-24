<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Parcela;

class ParcelaService
{

    public function listar($id)
    {
        // 1º Passo -> Buscar todas parcelas referentes ao id do contrato passado pela url
        $query = Parcela::where('fk_contrato', $id)->get();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
