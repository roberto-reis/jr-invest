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
            return $item->sum('percentual_na_carteira');
        });

        return Inertia::render('Admin/Rebalanceamento/Index', [
            'carteira' => $posicaoAtualComAjuste,
            'posicaoAtualClasseKeys' => $posicaoAtualClasse->keys(),
            'posicaoAtualClasseValues' => $posicaoAtualClasse->values(),
            'posicaoIdealClasseKeys' => $rebalanceamentoClasseIdeal->keys(),
            'posicaoIdealClasseValues' => $rebalanceamentoClasseIdeal->values(),
        ]);
    }
}
