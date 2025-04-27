<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RebalanceamentoException;
use Illuminate\Validation\ValidationException;
use App\Actions\Rebalanceamento\NovoRebalanceamentoAtivoAction;

class NovoRebalanceamentoAtivoController
{
    public function __invoke(Request $request, NovoRebalanceamentoAtivoAction $novoRebalanceamento)
    {
        try {
            $request->merge(['user_id' => Auth::user()->id]);

            $dataValidados = $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'ativo_uid' => [
                    'required', 'string', 'exists:ativos,uid',
                    Rule::unique('rebalanceamento_ativos')->where('user_id', Auth::user()->id),
                ],
                'percentual' => ['required', 'numeric', 'min:0', 'max:100'],
            ],
            [
                'ativo_uid.unique' => 'O ativo já está sendo utilizado em outro rebalanceamento.',
            ]);

            $novoRebalanceamento->execute($dataValidados);

            return redirect()->route('rebalanceamento.config')->with('success', 'Ativo percentual adicionado com sucesso');
        } catch (RebalanceamentoException $e) {
            return redirect()->route('rebalanceamento.config')->with('error', 'Erro ao adicionar ativo percentual: ' . $e->getMessage());
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException) {
                throw $th;
            }
            return redirect()->route('rebalanceamento.config')->with('error', 'Erro ao adicionar ativo percentual');
        }
    }
}
