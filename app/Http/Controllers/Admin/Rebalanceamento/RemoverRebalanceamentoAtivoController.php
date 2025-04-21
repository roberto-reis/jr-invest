<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use App\Models\RebalanceamentoAtivo;

class RemoverRebalanceamentoAtivoController
{
    public function __invoke($uid)
    {
        try {
            $rebalanceamentoAtivo = RebalanceamentoAtivo::where('uid', $uid)->firstOrFail();
            $rebalanceamentoAtivo->delete();

            return redirect()->route('rebalanceamento.index')->with('success', 'Ativo de rebalanceamento removido com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao remover ativo de rebalanceamento');
        }
    }
}
