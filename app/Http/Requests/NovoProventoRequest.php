<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class NovoProventoRequest extends FormRequest
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
            'ativo_uid' => 'required|exists:ativos,uid',
            'tipo_provento_uid' => 'required|exists:tipos_proventos,uid',
            'corretora_uid' => 'required|exists:corretoras,uid',
            'data_com' => 'required|date:Y-m-d',
            'data_pagamento' => 'required|date:Y-m-d',
            'quantidade_ativo' => 'required|numeric',
            'valor' => 'required|numeric',
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
