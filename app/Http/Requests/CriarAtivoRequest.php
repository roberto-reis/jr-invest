<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarAtivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Usuário autenticado pode criar ativos
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:20|unique:ativos,codigo',
            'nome' => 'required|string|max:255',
            'classe_ativo_uid' => 'required|string|exists:classes_ativos,uid',
            'setor' => 'required|string',
            'descricao' => 'required|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'codigo.required' => 'O código do ativo é obrigatório',
            'codigo.unique' => 'Este código de ativo já está em uso',
            'codigo.max' => 'O código deve ter no máximo 20 caracteres',
            'nome.required' => 'O nome do ativo é obrigatório',
            'classe_ativo_uid.required' => 'A classe do ativo é obrigatória',
            'classe_ativo_uid.exists' => 'A classe selecionada não existe',
            'setor.required' => 'O setor do ativo é obrigatório',
            'descricao.required' => 'A descrição do ativo é obrigatória',
            'descricao.max' => 'A descrição deve ter no máximo 1000 caracteres',
        ];
    }
}
