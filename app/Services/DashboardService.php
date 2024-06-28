<?php

namespace App\Services;

use App\Models\Contrato;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function listarInformacoes()
    {
        // 1º Passo -> Buscar a quantidade total de projetos e o valor total por empresa
        $query = Contrato::query();

        $query = $query->join('empresas', 'empresas.id', '=', 'contratos.fk_empresa')
            ->select('empresas.empresa', DB::raw('COUNT(contratos.id) as total_projetos'), DB::raw('SUM(contratos.valor_contrato) as valor_total'))
            ->groupBy('contratos.fk_empresa', 'empresas.empresa')
            ->get();

        // 2º Passo -> Retornar resposta

        if ($query) {
            return ['resposta' => 'Informações listadas com sucesso!', 'informacoes' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['resposta' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'informacoes' => null, 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
