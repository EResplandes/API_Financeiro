<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
            'empresa' => 'required|unique:empresas|string',
            'cnpj' => 'required|unique:empresas|integer'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'O campo :attribute é obrigatório!',
            'empresa.unique' => 'A empresa já está cadastrada!',
            'empresa.string' => 'O campo empresa deve ser do tipo texto',
            'cnpj.unique' => 'O CNPJ já está em uso!',
            'cnpj.integer' => 'O campo CNPJ deve conter apenas números!',
        ];
    }
}
