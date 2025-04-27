<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RebalanceamentoException;
use Illuminate\Validation\ValidationException;
use App\Actions\Rebalanceamento\AtualizarRebalanceamentoAtivoAction;

class AtualizarRebalanceamentoAtivoController
{
    public function __invoke(string $uid, Request $request, AtualizarRebalanceamentoAtivoAction $atualizarRebalanceamento)
    {
        try {
            $request->merge(['user_id' => Auth::user()->id]);

            $dataValidados = $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'ativo_uid' => [
                    'required',
                    'string',
                    'exists:ativos,uid',
                    Rule::unique('rebalanceamento_ativos')->where('user_id', Auth::user()->id)->ignore($uid, 'uid'),
                ],
                'percentual' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);

            $atualizarRebalanceamento->execute($dataValidados, $uid);

            return redirect()->route('rebalanceamento.config')->with('success', 'Ativo percentual atualizado com sucesso');
        } catch (RebalanceamentoException $e) {
            return redirect()->route('rebalanceamento.config')->with('error', 'Erro ao atualizar ativo percentual: ' . $e->getMessage());
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException) {
                throw $th;
            }
            return redirect()->route('rebalanceamento.config')->with('error', 'Erro ao atualizar ativo percentual');
        }
    }
}
