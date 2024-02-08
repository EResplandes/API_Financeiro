<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\UnidadeConsumidora;

class UnidadeConsumidoraService
{

    public function listarUnidades()
    {
        // 1º Passo -> Pegar todas unidades consumidoras
        $query = UnidadeConsumidora::all(); // Busca todas as unidades consumidoras

        // 2º Passo -> Retornar resposta
        if ($query) {
            return $query;
        } else {
            return 'Ocorreu algum erro, entre em contato com o Administrador!';
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
            return 'Unidade consumidora cadastrada com sucesso!';
        } else {
            return 'Ocorreu algum erro, entre em contato com o Administrador!';
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
            return 'Unidade consumidora atualizada com sucesso!';
        } else {
            return 'Ocorreu algum erro, entre em contato com o Administrador!';
        }
    }

    public function buscaUnidade($id)
    {
        // 1º Passo -> Buscar dados da Unidade Consumidora
        $query = UnidadeConsumidora::where('id', $id)->get();

        // 2º Passo -> Retornar resposta
        if ($query) {
            return $query;
        } else {
            return 'Ocorreu algum erro, entre em contato com o Administrador!';
        }
    }
}
