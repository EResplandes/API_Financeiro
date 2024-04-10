<?php

namespace App\Services;

use App\Models\Fornecedor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Banco;

class FornecedorService
{

    public function listar()
    {

        // 1º Passo -> Iniciar consulta
        $query = Fornecedor::query();

        // 2º Passo -> Consultar todos os fornecedores com seus dados bancarios caso existam
        $query = $query->join('dados_bancarios', 'dados_bancarios.id', '=', 'fornecedores.fk_banco');
        $query = $query->get();

        // 3º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function cadastro($request)
    {

        DB::beginTransaction();

        try {

            // 1ª Passo -> Montar array para inserir dados bancarios
            $arrayBanco = [
                'cod_banco' => $request->input('cod_banco'),
                'agencia' => $request->input('agencia'),
                'conta' => $request->input('conta'),
                'descricao_banco' => $request->input('descricao_banco')
            ];

            // 2º Passo -> Inserir os dados bancarios na tabela dados_bancario
            $queryInsert = Banco::insertGetId($arrayBanco);

            $arrayFornecedor = [];

            // 3º Passo -> Montar array para inserir dados
            if ($queryInsert) {
                $arrayFornecedor = [
                    'nome' => $request->input('nome'),
                    'nome_fantasia' => $request->input('nome_fantasia'),
                    'cnpj' => $request->input('cnpj'),
                    'login' => $request->input('login'),
                    'senha' => $request->input('senha'),
                    'fk_banco' => $queryInsert
                ];
            }

            // 4º Passo -> Inserir dados do fornecedor
            if ($arrayFornecedor) {
                $cadastrarFornecedor = Fornecedor::create($arrayFornecedor);
            }

            // 5º Passo -> Salvar dados no banco e Retornar resposta para o usuário
            if ($cadastrarFornecedor) {
                DB::commit();
                return ['mensagem' => 'Fornecedor cadastrado com sucesso!', 'status' => Response::HTTP_CREATED];
            }
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];

            throw $e;
        }
    }

    public function editar($request, $id)
    {
        dd($request->all(), $id);
    }
}
