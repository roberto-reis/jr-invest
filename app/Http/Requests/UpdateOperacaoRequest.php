<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOperacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Usuário autenticado pode criar ativos
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::user()->id
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
            'user_id' => 'required|exists:users,id',
            'ativo_uid' => 'required|string|exists:ativos,uid',
            'tipo_operacao_uid' => 'required|string|exists:tipos_operacoes,uid',
            'corretora_uid' => 'required|string|exists:corretoras,uid',
            'cotacao_preco' => 'required|numeric',
            'quantidade' => 'required|numeric',
            'data_operacao' => 'required|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [];
    }
}
