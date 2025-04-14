<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RebalanceamentoException;
use Illuminate\Validation\ValidationException;
use App\Actions\Rebalanceamento\NovoRebalanceamentoClasseAction;

class NovoRebalanceamentoClasseController
{
    public function __invoke(Request $request, NovoRebalanceamentoClasseAction $novoRebalanceamento)
    {
        try {
            $request->merge(['user_id' => Auth::user()->id]);

            $dataValidados = $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'classe_ativo_uid' => [
                    'required',
                    'string',
                    'exists:classes_ativos,uid',
                    Rule::unique('rebalanceamento_classes')->where('user_id', Auth::user()->id),
                ],
                'percentual' => ['required', 'numeric', 'min:0', 'max:100'],
            ],
            [
                'classe_ativo_uid.unique' => 'A classe já está sendo utilizada em outro rebalanceamento.',
            ]
        );

            $novoRebalanceamento->execute($dataValidados);

            return redirect()->route('rebalanceamento.index')->with('success', 'Classe percentual adicionada com sucesso');
        } catch (RebalanceamentoException $e) {
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao adicionar classe percentual: ' . $e->getMessage());
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException) {
                throw $th;
            }
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao adicionar classe percentual');
        }
    }
}
