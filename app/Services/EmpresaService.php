<?php

namespace App\Services;

use App\Models\Empresa;
use Illuminate\Http\Response;
use GuzzleHttp\Psr7\Request;

class EmpresaService
{

    public function listarEmpresas()
    {
        // 1ª Passo -> Buscar todas Empresas
        $query = Empresa::all();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function listarFiltros($request)
    {
        // 1ª Passo -> Inicia consulta
        $query = Empresa::query();

        // 2º Passo -> Verifica se os campos foram passador por url para aplicar filtros
        if ($request->query('empresa')) {
            $query = $query->where('empresa', 'LIKE', '%' . $request->query('empresa') . '%');
        }

        if ($request->query('cnpj')) {
            $query = $query->where('cnpj', $request->query('cnpj'));
        }

        // 3º Passo -> Realiza consulta
        $query = $query->get();

        // 4º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function cadastrarEmpresa($request)
    {
        // 1º Passo -> Pegar informações a serem inseridas
        $dados = [
            'empresa' => $request->input('empresa'),
            'cnpj' => $request->input('cnpj')
        ];

        // 2º Passo -> Inserir dados 
        $query = Empresa::create($dados);

        // 3ª Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => 'A empresa foi cadastrada com sucesso!', 'status' => Response::HTTP_CREATED];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function editarEmpresa($request, $id)
    {
        // 1º Passo -> Pegar dados a serem atualizados
        $dados = [];

        // Verifica se o campo 'empresa' existe na requisição e adiciona ao array $dados
        if ($request->has('empresa')) {
            $dados['empresa'] = $request->input('empresa');
        }

        // Verifica se o campo 'cnpj' existe na requisição e adiciona ao array $dados
        if ($request->has('cnpj')) {
            $dados['cnpj'] = $request->input('cnpj');
        }

        // Verifica se nenhum dos campos 'empresa' e 'cnpj' está preenchido e retorna a mensagem
        if (empty($dados)) {
            return ['mensagem' => 'Preencha pelo menos 1 campo.', 'status' => Response::HTTP_BAD_REQUEST];
        }

        // 2º Passo -> Atualizar dados
        $query = Empresa::where('id', $id)->update($dados);

        // 3º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => 'Empresa atualizada com sucesso!', 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function buscaEmpresa($id)
    {
        // 1ª Passo -> Pegar dados da empresa de acordo com id
        $query = Empresa::where('id', $id)->get();

        // 2ª Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status', Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
