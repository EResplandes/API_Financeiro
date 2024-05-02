<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'servico' => 'required|string|min:5',
            'contrato' => 'integer',
            'fk_empresa' => 'required|integer',
            'fk_unidade' => 'required|integer',
            'fk_fornecedor' => 'required|integer',
            'qtd_parcelas' => 'integer',
            'mes_referencia' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'servico.required' => 'O campo SERVIÇO é obrigatório!',
            'servico.required' => 'O campo SERVIÇO deve ser um texto!',
            'servico.min' => 'O campo SERVIÇO deve conter no mínimo 5 caracteres!',
            'contrato.integer' => 'O campo CONTRATO deve ser um número informando o número do contrato!',
            'fk_empresa.required' => 'É OBRIGATÓRIO selecionar uma empresa!',
            'fk_empresa.integer' => 'O campo EMPRESA deve ser precisa ser um número!',
            'fk_unidade.required' => 'É OBRIGATÓRIO selecionar uma unidade consumidora!',
            'fk_unidade.integer' => 'O campo UNIDADE deve ser precisa ser um número!',
            'fk_fornecedor.required' => 'É OBRIGATÓRIO selecionar um fornecedor!',
            'fk_fornecedor.integer' => 'O campo FORNECEDOR deve ser precisa ser um número!',
            'qtd_parcelas.integer' => 'O campo de QUANTIDADE DE PARCELAS deve ser um número inteiro!',
            'mes_referencia.integer' => 'O campo de MÊS REFERÊNCIA deve ser um número inteiro!',
        ];
    }
}
