<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CriarClasseAtivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Usuário autenticado pode criar classes de ativos
    }

    public function prepareForValidation()
    {
        $this->merge([
            'nome_interno' => Str::slug($this->nome),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'descricao' => ['required', 'string', 'min:3', 'max:255'],
            'nome_interno' => ['unique:classes_ativos,nome_interno'],
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
            'nome.required' => 'O nome da classe de ativo é obrigatório',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            'descricao.required' => 'A descrição da classe de ativo é obrigatória',
            'descricao.min' => 'A descrição deve ter no mínimo 3 caracteres',
            'descricao.max' => 'A descrição deve ter no máximo 255 caracteres',
            'nome_interno.unique' => 'O nome da classe de ativo já está em uso',
        ];
    }
}
