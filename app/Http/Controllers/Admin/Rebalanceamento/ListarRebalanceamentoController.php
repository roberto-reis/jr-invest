<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Inertia\Inertia;
use App\Models\RebalanceamentoAtivo;
use Illuminate\Support\Facades\Auth;
use App\Models\RebalanceamentoClasse;
use App\Actions\Rebalanceamento\ListarPosicaoAjusteAction;

class ListarRebalanceamentoController
{
    public function __construct(
        public ListarPosicaoAjusteAction $listarPosicaoAjusteAction
    ){}

    public function __invoke()
    {
        $rebalanceamentoClasseIdeal = RebalanceamentoClasse::where('user_id', Auth::user()->id)
                                        ->joinClasseAtivo()
                                        ->pluck('percentual', 'nome');

        $posicaoAtualComAjuste = $this->listarPosicaoAjusteAction->execute();

        $posicaoAtualClasse = $posicaoAtualComAjuste->groupBy('classe_ativo')->map(function ($item) {
            return (float)number_format($item->sum('percentual_na_carteira'), 2);
        });

        $feedback = null;
        if ($rebalanceamentoClasseIdeal->isEmpty()) {
            $feedback = 'Nenhuma posição ideal configurada. Acesse "Config. Rebalanceamento" para definir a posição ideal por classe.';
        }

        return Inertia::render('Admin/Rebalanceamento/Index', [
            'carteira' => $posicaoAtualComAjuste,
            'posicaoAtualClasseKeys' => $posicaoAtualClasse->keys(),
            'posicaoAtualClasseValues' => $posicaoAtualClasse->values(),
            'posicaoIdealClasseKeys' => $rebalanceamentoClasseIdeal->keys(),
            'posicaoIdealClasseValues' => $rebalanceamentoClasseIdeal->values(),
            'feedback' => $feedback,
        ]);
    }
}
