<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeConsumidoraRequest extends FormRequest
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
            'nome' => 'required|unique:unidades_consumidoras'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo unidade consumidora é obrigatório!',
            'nome.unique' => 'A unidade consumidora já está cadastrada!'
        ];
    }
}
