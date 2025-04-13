<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RebalanceamentoException;
use App\Actions\Rebalanceamento\NovoRebalanceamentoClasseAction;

class NovoRebalanceamentoClasseController
{
    public function __invoke(Request $request, NovoRebalanceamentoClasseAction $novoRebalanceamento)
    {
        try {
            $request->merge(['user_id' => Auth::user()->id]);

            $dataValidados = $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'classe_ativo_uid' => ['required', 'string', 'exists:classes_ativos,uid'],
                'percentual' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);

            $novoRebalanceamento->execute($dataValidados);

            return redirect()->route('rebalanceamento.index')->with('success', 'Classe percentual adicionada com sucesso');
        } catch (RebalanceamentoException $e) {
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao adicionar classe percentual: ' . $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao adicionar classe percentual');
        }
    }
}
