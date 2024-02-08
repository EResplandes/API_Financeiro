<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Models\UnidadeConsumidora;

class UnidadeConsumidoraService
{

    public function listarUnidades()
    {
        // 1º Passo -> Pegar todas unidades consumidoras
        $query = UnidadeConsumidora::all(); // Busca todas as unidades consumidoras

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function cadastraUnidade($request)
    {
        // 1º Passo -> Pegar dados a serem inseridos
        $dados = [
            'nome' => $request->input('nome')
        ];

        // 2º Passo -> Cadastrar unidade consumidora
        $query = UnidadeConsumidora::create($dados);

        // 3º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => 'Unidade consumidora cadastrada com sucesso!', 'status' => Response::HTTP_CREATED];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function editarUnidade($request, $id)
    {
        // 1º Passo -> Pegar dados a serem atualizados
        $dados = [
            'nome' => $request->input('nome'),
        ];

        // 2º Passo -> Atualizar dados da unidade de acordo com id
        $query = UnidadeConsumidora::where('id', $id)->update($dados);

        // 3ª Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => 'Unidade consumidora atualizada com sucesso!', 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }

    public function buscaUnidade($id)
    {
        // 1º Passo -> Buscar dados da Unidade Consumidora
        $query = UnidadeConsumidora::where('id', $id)->get();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return ['mensagem' => $query, 'status' => Response::HTTP_OK];
        } else {
            return ['mensagem' => 'Ocorreu algum erro, entre em contato com o Administrador!', 'status' => Response::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
