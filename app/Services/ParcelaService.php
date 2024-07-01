<?php

namespace App\Services;

use App\Models\Contrato;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Parcela;
use Illuminate\Support\Carbon;

class ParcelaService
{
    public function listar($id)
    {
        // 1º Passo -> Buscar todas parcelas referentes ao id do contrato passado pela url
        $query = Parcela::query();
        $query = $query->join('status_parcelas', 'status_parcelas.id', '=', 'parcelas.fk_status');
        $query = $query->select('parcelas.id', 'parcelas.mes_referencia', 'parcelas.dt_vencimento', 'parcelas.observacao', 'parcelas.valor', 'parcelas.id_pedido', 'parcelas.comprovante', 'status_parcelas.status');
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
        DB::beginTransaction();

        try {
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

            // 3º Passo -> Incrementar o valor da parcela no contrato
            $idContrato = $request->input('fk_contrato');

            $valorContrato = Contrato::where('id', $idContrato)->pluck('valor_contrato')->first();

            $valorAtual = intval($request->input('valor_parcela')) + $valorContrato;

            Contrato::where('id', $idContrato)->update(['valor_contrato' => $valorAtual]);

            // 4º Passo -> Atualizar qtd de parcelas
            $totalParcelas = Parcela::where('fk_contrato', $idContrato)->count();

            Contrato::where('id', $idContrato)->update(['qtd_parcelas' => $totalParcelas]);

            // 5º Passo -> Retornar resposta para o usuário
            DB::commit();
            return ['mensagem' => 'Parcela cadastrada com sucesso!', 'status' => Response::HTTP_CREATED];
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['mensagem' => $e, 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function excluir($id)
    {
        DB::beginTransaction();

        try {

            // 1º Passo -> Pegar id do contrato
            $idContrato = Parcela::where('id', $id)->pluck('fk_contrato')->first();

            // 2º Passo -> Excluir parcela de acordo com id
            Parcela::where('id', $id)->delete();

            // 3º Passo -> Atualizar valor do contrato
            $valorContrato = Parcela::where('fk_contrato', $idContrato)->sum('valor');

            Contrato::where('id', $idContrato)->update(['valor_contrato' => $valorContrato]);

            // 4º Passo -> Atualizar qtd de parcelas do contrato
            $totalParcelas = Parcela::where('fk_contrato', $idContrato)->count();

            Contrato::where('id', $idContrato)->update(['qtd_parcelas' => $totalParcelas]);

            // 5º Passo -> Retornar resposta
            DB::commit();
            return ['mensagem' => 'Parcela excluida com sucesso!', 'status' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['mensagem' => $e, 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function statusLink($id, $idPedido)
    {
        // 1º Passo -> Atualizar status da parcela para 02 (Enviado para Aprovação) e atualziar informando id do registro no link
        $query = Parcela::where('id', $id)
            ->update([
                'fk_status' => 2,
                'id_pedido' => $idPedido
            ]);

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['resposta' => 'Parcela enviada para o link com sucesso!', 'status' => Response::HTTP_ACCEPTED];
        } else {
            return ['resposta' => 'Ocorreu algum problema, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function aprovaParcela($id)
    {
        try {
            // 1º Passo -> Pegar id da parcela de acordo com id do pedido
            $idParcela = Parcela::where('id_pedido', $id)
                ->pluck('id')
                ->first();

            // 2º Passo -> Atualizar status para 4
            Parcela::where('id', $idParcela)
                ->update(['fk_status' => 4]);

            DB::commit();
            return ['resposta' => 'Parcela atualizada com sucesso!', 'status' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['resposta' => $e, 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function reprovaParcela($id)
    {
        try {
            // 1º Passo -> Pegar id da parcela de acordo com id do pedido
            $idParcela = Parcela::where('id_pedido', $id)
                ->pluck('id')
                ->first();

            // 2º Passo -> Atualizar status para 5
            Parcela::where('id', $idParcela)
                ->update(['fk_status' => 4]);

            DB::commit();
            return ['resposta' => 'Parcela atualizada com sucesso!', 'status' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['resposta' => $e, 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function anexarComprovante($request)
    {

        DB::beginTransaction();

        try {

            // 1º Passo -> Verificar se o comprovante foi passado
            if (!$request->file('comprovante')) {
                return ['resposta' => 'O envio do comprovante é obrigatório!', 'status' => Response::HTTP_BAD_REQUEST];
            }

            // 2º Passo -> Salvar comprovante e pegar caminho
            $directory = "/comprovantes"; // Criando diretório

            $pdf = $request->file('comprovante')->store($directory, 'public'); // Salvando pdf do comprovante

            // 3º Passo -> Salvar diretório da parcela e alterar status
            Parcela::where('id', $request->input('id_parcela'))
                ->update([
                    'comprovante' => $pdf,
                    'fk_status' => 6
                ]);

            // 4º Passo -> Retornar resposta
            DB::commit();
            return ['resposta' => 'Comprovante anexado com sucesso!', 'status' => Response::HTTP_CREATED];
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['resposta' => $e, 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
