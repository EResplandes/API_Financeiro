<?php

namespace App\Services;

use App\Models\Fornecedor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Banco;

use App\Http\Resources\FornecedoresResource;

class FornecedorService
{

    public function listar()
    {

        // return ['mensagem' => FornecedoresResource::collection(Fornecedor::all()), 'status' => Response::HTTP_OK];

        // 1º Passo -> Iniciar consulta
        $query = Fornecedor::query();

        // 2º Passo -> Consultar todos os fornecedores com seus dados bancarios caso existam
        $query = $query->join('dados_bancarios', 'dados_bancarios.id', '=', 'fornecedores.fk_banco');
        $query = $query->select('fornecedores.id', 'fornecedores.nome', 'fornecedores.nome_fantasia', 'fornecedores.cnpj', 'fornecedores.login', 'fornecedores.login', 'fornecedores.senha', 'fornecedores.fk_banco', 'dados_bancarios.cod_banco', 'dados_bancarios.agencia', 'dados_bancarios.conta', 'dados_bancarios.descricao_banco');
        $query = $query->get();

        // 3º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function listarFiltros($request)
    {
        // 1º Passo -> Iniciar consulta
        $query = Fornecedor::query();

        // 2º Passo -> Consultar todos os fornecedores com seus dados bancarios caso existam
        $query = $query->join('dados_bancarios', 'dados_bancarios.id', '=', 'fornecedores.fk_banco');
        $query = $query->select('fornecedores.id', 'fornecedores.nome', 'fornecedores.nome_fantasia', 'fornecedores.cnpj', 'fornecedores.login', 'fornecedores.login', 'fornecedores.senha', 'fornecedores.fk_banco', 'dados_bancarios.cod_banco', 'dados_bancarios.agencia', 'dados_bancarios.conta', 'dados_bancarios.descricao_banco');

        // 3º Passo -> Verifica se os campos foram passador por url para aplicar filtros
        if ($request->query('nome')) {
            $query = $query->where('nome', 'LIKE', '%' . $request->query('nome') . '%');
        }

        if ($request->query('nome_fantasia')) {
            $query = $query->where('nome_fantasia', 'LIKE', '%' . $request->query('nome_fantasia') . '%');
        }

        if ($request->query('cnpj')) {
            $query = $query->where('cnpj', $request->query('cnpj'));
        }

        // 4º Passo -> Buscar fornecedores
        $query = $query->get();

        // 5º Passo -> Retornar resposta
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

        // 1º Passo -> Pegar dados a serem atualizados
        $dados = [];
        $dadosBanco = [];

        // Verifica se o campo 'nome' existe na requisição e adiciona ao array $dados
        if ($request->has('nome')) {
            $dados['nome'] = $request->input('nome');
        }

        // Verifica se o campo 'nome_fantasia' existe na requisição e adiciona ao array $dados
        if ($request->has('nome_fantasia')) {
            $dados['nome_fantasia'] = $request->input('nome_fantasia');
        }

        // Verifica se o campo 'cnpj' existe na requisição e adiciona ao array $dados
        if ($request->has('cnpj')) {
            $dados['cnpj'] = $request->input('cnpj');
        }

        // Verifica se o campo 'logn' existe na requisição e adiciona ao array $dados
        if ($request->has('login')) {
            $dados['login'] = $request->input('login');
        }

        // Verifica se o campo 'senha' existe na requisição e adiciona ao array $dados
        if ($request->has('senha')) {
            $dados['senha'] = $request->input('senha');
        }

        // Verifica se o campo 'senha' existe na requisição e adiciona ao array $dados
        if ($request->has('senha')) {
            $dados['senha'] = $request->input('senha');
        }

        // Verifica se o campo 'cod_banco' existe na requisição e adiciona ao array $dados
        if ($request->has('cod_banco')) {
            $dadosBanco['cod_banco'] = $request->input('cod_banco');
        }

        // Verifica se o campo 'agencia' existe na requisição e adiciona ao array $dadosBanco
        if ($request->has('agencia')) {
            $dadosBanco['agencia'] = $request->input('agencia');
        }

        // Verifica se o campo 'conta' existe na requisição e adiciona ao array $dadosBanco
        if ($request->has('conta')) {
            $dadosBanco['conta'] = $request->input('conta');
        }

        // Verifica se o campo 'descricao_banco' existe na requisição e adiciona ao array $dadosBanco
        if ($request->has('descricao_banco')) {
            $dadosBanco['descricao_banco'] = $request->input('descricao_banco');
        }

        // Verifica se nenhum dos campos está preenchido e retorna a mensagem
        if (empty($dados)) {
            return ['mensagem' => 'Preencha pelo menos 1 campo.', 'status' => Response::HTTP_BAD_REQUEST];
        }

        // 2º Passo -> Pegar id do banco
        $fk_banco = Fornecedor::where('id', $id)->select('fk_banco')->value('fk_banco');


        DB::beginTransaction();

        try {

            // 3º Passo -> Atualizar dados do fornecedor
            $queryUpdateFornecedor = Fornecedor::where('id', $id)->update($dados); // Atualizando dados do fornecedor

            if ($queryUpdateFornecedor) {
                // 4º Passo -> Atualizar dados do banco
                $queryUpdateBanco = Banco::where('id', $fk_banco)->update($dadosBanco);

                if ($queryUpdateBanco) {
                    DB::commit(); // Salvar alterações
                    return ['mensagem' => 'Fornecedor atualizado com sucesso!', 'status' => Response::HTTP_OK];
                }
            }
        } catch (\Exception $e) {
            DB::rollback(); // Se uma exceção ocorrer durante as operações do banco de dados, fazemos o rollback

            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];

            throw $e;
        }
    }
}
