<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Parcela;
use App\Models\HistoricoParcela;
use Illuminate\Support\Carbon;

class ParcelaService
{

    public function listar($id)
    {
        // 1º Passo -> Buscar todas parcelas referentes ao id do contrato passado pela url
        $query = Parcela::query();
        $query = $query->join('status_parcelas', 'status_parcelas.id', '=', 'parcelas.fk_status');
        $query = $query->where('fk_contrato', $id)->get();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function cadastrar($request)
    {
        // 1º Passo -> Montar array para ser inserido
        $dados = [
            'fk_contrato' => $request->input('fk_contrato'),
            'mes_referencia' => $request->input('mes_referencia'),
            'dt_vencimento' => $request->input('dt_vencimento'),
            'observacao' => $request->input('observacao'),
            'valor' => $request->input('valor_parcela'),
            'fk_status' => 1
        ];

        // 2º Passo -> Inserir parcela
        $query = Parcela::create($dados);

        // 3º Passo -> Retornar resposta para o usuário
        if ($query) {
            return ['mensagem' => 'Parcela cadastrada com sucesso!', 'status' => Response::HTTP_CREATED];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function diretoria($id)
    {

        DB::beginTransaction();

        try {

            // 1º Passo -> Alterar status para enviado para diretoria
            $query = Parcela::where('id', $id)->update(['fk_status' => 2]);

            // 2º Passo -> Inserir no histórico da parcela
            if ($query) {

                // Montando array
                $dados = [
                    'data_status' => Carbon::now('America/Sao_Paulo'),
                    'fk_parcela' => $id,
                    'observacao' => 'Enviado para diretória!'
                ];

                // Inserindo histórico
                $historico = HistoricoParcela::create($dados);
            }

            // 3º Passo -> Retornar resposta para requisição
            if ($historico) {
                DB::commit(); // Salvando alterações
                return ['mensagem' => 'Parcela encaminhada para diretoria com sucesso!!', 'status' => Response::HTTP_OK];
            } else {
                return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
            }
        } catch (\Exception $e) {

            // 1ª Passo -> Desafendo todas as alterações
            DB::rollBack();

            // 2º Passo -> Retornar resposta
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function presidencia($id)
    {

        DB::beginTransaction();

        try {

            // 1º Passo -> Alterar status para enviado para presidencia
            $query = Parcela::where('id', $id)->update(['fk_status' => 3]);

            // 2º Passo -> Inserir no histórico da parcela
            if ($query) {

                // Montando array
                $dados = [
                    'data_status' => Carbon::now('America/Sao_Paulo'),
                    'fk_parcela' => $id,
                    'observacao' => 'Enviado para presidência!'
                ];

                // Inserindo histórico
                $historico = HistoricoParcela::create($dados);
            }

            // 3º Passo -> Retornar resposta para requisição
            if ($historico) {
                DB::commit(); // Salvando alterações
                return ['mensagem' => 'Parcela encaminhada para presidência com sucesso!!', 'status' => Response::HTTP_OK];
            } else {
                return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
            }
        } catch (\Exception $e) {

            // 1ª Passo -> Desafendo todas as alterações
            DB::rollBack();

            // 2º Passo -> Retornar resposta
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
