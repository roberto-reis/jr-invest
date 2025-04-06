<?php

namespace App\Http\Requests;

use App\Models\Ativo;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAtivoRequest extends FormRequest
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
            'codigo' => ['required', 'string', 'min:3', 'max:255', Rule::unique('ativos', 'codigo')->ignore($this->route('uid'), 'uid')],
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'classe_ativo_uid' => ['required', 'string', 'min:3', 'max:255'],
            'setor' => ['required', 'string', 'min:3', 'max:255'],
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
            'codigo.unique' => 'Já existe um ativo com este código',
            'classe_ativo_uid.required' => 'A classe do ativo é obrigatória',
            'setor.required' => 'O setor do ativo é obrigatório',
            'codigo.required' => 'O código do ativo é obrigatório',
            'nome.required' => 'O nome do ativo é obrigatório',
        ];
    }
}
