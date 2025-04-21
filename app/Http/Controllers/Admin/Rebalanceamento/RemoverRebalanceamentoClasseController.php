<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use App\Models\RebalanceamentoClasse;

class RemoverRebalanceamentoClasseController
{
    public function __invoke($uid)
    {
        try {
            $rebalanceamentoClasse = RebalanceamentoClasse::where('uid', $uid)->firstOrFail();
            $rebalanceamentoClasse->delete();

            return redirect()->route('rebalanceamento.index')->with('success', 'Classe de rebalanceamento removida com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('rebalanceamento.index')->with('error', 'Erro ao remover classe de rebalanceamento');
        }
    }
}
