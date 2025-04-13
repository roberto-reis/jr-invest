<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RebalanceamentoException;
use App\Actions\Rebalanceamento\NovoRebalanceamentoAtivoAction;

class NovoRebalanceamentoAtivoController
{
    public function __invoke(Request $request, NovoRebalanceamentoAtivoAction $novoRebalanceamento)
    {
        try {
            $request->merge(['user_id' => Auth::user()->id]);

            $dataValidados = $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'ativo_uid' => ['required', 'string', 'exists:ativos,uid'],
                'percentual' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);

            $novoRebalanceamento->execute($dataValidados);

            return redirect()->route('rebalanceamento.index')->with('success', 'Ativo percentual adicionado com sucesso');
        } catch (RebalanceamentoException $e) {
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao adicionar ativo percentual: ' . $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao adicionar ativo percentual');
        }
    }
}
