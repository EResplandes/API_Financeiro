<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedoresRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'cnpj' => 'required|integer',
            'cod_banco' => 'required|integer',
            'agencia' => 'required|integer',
            'conta' => 'required|integer',
            'descricao_banco' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome_fantasia.required' => 'O campo nome fantasia é obrigatório!',
            'cnpj.required' => 'O campo cnpj é obrigatório',
            'cod_banco.required' => 'O campo código do banco é obrigatório',
            'agencia.required' => 'O campo agência é obrigatório',
            'conta.required' => 'O campo conta é obrigatório',
            'conta.required' => 'O campo conta é obrigatório',
            'descricao_banco.required' => 'O campo descrição000000000000000000000000 é obrigatório'
        ];
    }
}
