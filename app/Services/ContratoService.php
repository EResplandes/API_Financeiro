<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Models\Contrato;

class ContratoService
{

    public function listar()
    {
        // 1º Passo -> Buscar todos contratos com os devidos joins
        $query = Contrato::query();
        $query = $query->join('empresas', 'empresas.id', '=', 'contratos.fk_empresa');
        $query = $query->join('fornecedores', 'fornecedores.id', '=', 'contratos.fk_fornecedor');
        $query = $query->join('unidades_consumidoras', 'unidades_consumidoras.id', '=', 'contratos.unidade');
        $query = $query->select(
            'contratos.id',
            'contratos.service',
            'contratos.qtd_parcelas',
            'contratos.valor_contrato',
            'empresas.nome AS nome_empresa',
            'fornecedores.nome',
            'fornecedores.cnpj',
            'unidades_consumidoras.nome AS unidade_consumidora'
        );
        $query = $query->get();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return response()->json(['mensagem' => $query, 'status' => Response::HTTP_OK]);
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function cadastrar($request)
    {
        dd('teste');
    }
}
