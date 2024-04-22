<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Models\Contrato;
use App\Models\Parcela;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;


class ContratoService
{

    public function listar()
    {
        // 1º Passo -> Buscar todos contratos com os devidos joins
        $query = Contrato::query();
        $query = $query->join('empresas', 'empresas.id', '=', 'contratos.fk_empresa');
        $query = $query->join('fornecedores', 'fornecedores.id', '=', 'contratos.fk_fornecedor');
        $query = $query->join('unidades_consumidoras', 'unidades_consumidoras.id', '=', 'contratos.fk_unidade');
        $query = $query->select(
            'contratos.id',
            'contratos.servico',
            'contratos.qtd_parcelas',
            'contratos.valor_contrato',
            'empresas.id AS id_empresa',
            'empresas.empresa AS nome_empresa',
            'fornecedores.nome',
            'fornecedores.nome_fantasia',
            'fornecedores.cnpj',
            'unidades_consumidoras.nome AS unidade_consumidora'
        );
        $query = $query->get();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function listarFiltros($request)
    {

        // 1º Passo -> Buscar todos contratos com os devidos joins
        $query = Contrato::query();
        $query = $query->join('empresas', 'empresas.id', '=', 'contratos.fk_empresa');
        $query = $query->join('fornecedores', 'fornecedores.id', '=', 'contratos.fk_fornecedor');
        $query = $query->join('unidades_consumidoras', 'unidades_consumidoras.id', '=', 'contratos.fk_unidade');
        $query = $query->select(
            'contratos.id',
            'contratos.servico',
            'contratos.qtd_parcelas',
            'contratos.valor_contrato',
            'empresas.id AS id_empresa',
            'empresas.empresa AS nome_empresa',
            'fornecedores.nome',
            'fornecedores.nome_fantasia',
            'fornecedores.cnpj',
            'unidades_consumidoras.nome AS unidade_consumidora'
        );

        // 2º Passo -> Verifica se os campos foram passador por url para aplicar filtros
        if ($request->query('servico')) {
            $query = $query->where('contratos.servico', 'LIKE', '%' . $request->query('servico') . '%');
        }

        if ($request->query('id_empresa')) {
            $query = $query->where('contratos.fk_empresa', $request->query('id_empresa'));
        }

        $query = $query->get(); // Executando a consulta

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function cadastrar($request)
    {
        // 1º Passo -> Montar array para inserção de dados
        $dados = [
            'servico' => $request->input('servico'),
            'contrato' => $request->input('contrato'),
            'fk_empresa' => $request->input('fk_empresa'),
            'fk_unidade' => $request->input('fk_unidade'),
            'fk_fornecedor' => $request->input('fk_fornecedor'),
            'qtd_parcelas' => $request->input('qtd_parcelas'),
            'valor_contrato' => $request->input('valor_contrato'),
            'mes_referencia' => $request->input('mes_referencia'),
            'data_vencimento' => $request->input('data_vencimento')
        ];

        // 2º Passo -> Verificar se o checkbox onde gera parcelas automáticas está ativo
        if ($request->input('parcela_automatica') == 'true') {
            return $this->cadastrarParcela($dados);
        } else {
            // 3º -> Se não, apenas cadastrar na tabela contratos
            $query = Contrato::create($dados);

            if ($query) {
                return ['mensagem' => 'Contrato criado com sucesso!', 'status' => Response::HTTP_OK];
            } else {
                return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
            }
        }
    }

    public function cadastrarParcela($dados)
    {
        DB::beginTransaction();

        try {
            // 1º Passo -> Cadastrar contrato
            $novo_contrato = Contrato::create($dados);
            $id_contrato = $novo_contrato->id;

            // 2º Passo -> Calcular valor da parcela
            $valorParcela = $dados['valor_contrato'] / $dados['qtd_parcelas'];

            // 3º Passo -> Obter o mês de referência inicial
            $mesReferencia = date('m', strtotime($dados['mes_referencia']));
            $anoAtual = date('Y');

            // 4º Passo -> Obter o dia e o mês da primeira data de vencimento
            $diaMesVencimento = date('d-m', strtotime($dados['data_vencimento']));

            // 5º Passo -> Inserir parcelas
            $parcelas = [];

            $arrayPrimeiro = [
                'fk_contrato' => $id_contrato,
                'mes_referencia' => $dados['mes_referencia'],
                'dt_vencimento' => $dados['data_vencimento'],
                'observacao' => 'N/C',
                'valor' => $valorParcela
            ];

            Parcela::insert($arrayPrimeiro); // Primeiro Insert 

            for ($i = 1; $i <= $dados['qtd_parcelas']; $i++) {
                // Atualizar a data de vencimento e a referência do mês para cada parcela
                $dtVencimento = date('Y-m-d', strtotime("$diaMesVencimento-$anoAtual +$i months"));

                // Incrementar o mês de referência, garantindo que não ultrapasse 12
                $mesReferencia += 1;
                if ($mesReferencia > 12) {
                    $mesReferencia = 1; // Voltar para janeiro
                    $anoAtual += 1; // Incrementar o ano
                }

                // Montar array para inserir na tabela de parcelas
                $arrayInsert = [
                    'fk_contrato' => $id_contrato,
                    'mes_referencia' => $mesReferencia,
                    'dt_vencimento' => $dtVencimento,
                    'observacao' => 'N/C',
                    'valor' => $valorParcela
                ];
                $parcelas[] = $arrayInsert;
            }

            // 6º Passo -> Cadastrar as parcelas na tabela parcelas
            Parcela::insert($parcelas);

            // 7º Passo -> Retornar resposta
            DB::commit();
            return ['mensagem' => 'Contrato criado com sucesso!', 'status' => Response::HTTP_OK];
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];

            throw $e;
        }
    }

    public function busca($id)
    {
        // 1º Passo -> Buscar todos contratos com os devidos joins
        $query = Contrato::query();
        $query = $query->join('empresas', 'empresas.id', '=', 'contratos.fk_empresa');
        $query = $query->join('fornecedores', 'fornecedores.id', '=', 'contratos.fk_fornecedor');
        $query = $query->join('unidades_consumidoras', 'unidades_consumidoras.id', '=', 'contratos.fk_unidade');
        $query = $query->select(
            'contratos.id',
            'contratos.servico',
            'contratos.qtd_parcelas',
            'contratos.valor_contrato',
            'empresas.id AS id_empresa',
            'empresas.empresa AS nome_empresa',
            'fornecedores.nome',
            'fornecedores.nome_fantasia',
            'fornecedores.cnpj',
            'unidades_consumidoras.nome AS unidade_consumidora'
        );
        $query = $query->where('contratos.id', $id);
        $query = $query->get();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
