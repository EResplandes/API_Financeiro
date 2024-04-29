<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParcelaRequest extends FormRequest
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
            'mes_referencia' => 'required',
            'dt_vencimento' => 'required|date',
            'valor_parcela' => 'numeric',
            'fk_contrato' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'O campo :attribute é obrigatório!',
            'dt_vencimento.date' => 'O campo data vencimento deve ser uma data valida!',
            'observacao.string' => 'O campo observação deve ser um texto!',
            'valor_parcela.numeric' => 'O valor deve ser um número valido!',
            'fk_contrato.integer' => 'Informe o contrato referente a parcela!'
        ];
    }
}
