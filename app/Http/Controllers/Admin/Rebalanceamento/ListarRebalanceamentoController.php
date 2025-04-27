<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Inertia\Inertia;
use App\Actions\Portfolio\ListarPortifolioAction;
use App\Models\RebalanceamentoAtivo;
use App\Models\RebalanceamentoClasse;
use Illuminate\Support\Facades\Auth;

class ListarRebalanceamentoController
{
    public function __construct(
        public ListarPortifolioAction $listarPortifolioAction
    ){}

    public function __invoke()
    {
        // Calcular posição atual
        $posicaoAtual = $this->listarPortifolioAction->execute();
        $posicaoIdeal = RebalanceamentoAtivo::where('user_id', Auth::user()->id)->pluck('percentual', 'ativo_uid');
        $rebalanceamentoClasseIdeal = RebalanceamentoClasse::where('user_id', Auth::user()->id)
                                        ->join('classes_ativos', 'rebalanceamento_classes.classe_ativo_uid', '=', 'classes_ativos.uid')
                                        ->pluck('percentual', 'nome');

        $patrimonioTotal = $posicaoAtual->sum('patrimonio');
        $posicaoAtual->each(function ($carteiraItem) use ($posicaoIdeal, $patrimonioTotal) {
            $carteiraItem->percentual_ideal = $posicaoIdeal[$carteiraItem->ativo_uid];
            $carteiraItem->valor_ideal = $patrimonioTotal * ($carteiraItem->percentual_ideal / 100);
            $carteiraItem->quntidade_ideal = $carteiraItem->valor_ideal / $carteiraItem->cotacao_atual;

            $valorAjuste = $carteiraItem->valor_ideal - $carteiraItem->patrimonio;
            $carteiraItem->valor_ajuste = abs($valorAjuste);
            $carteiraItem->quantidade_ajuste = abs($carteiraItem->quntidade_ideal - $carteiraItem->quantidade);
            $carteiraItem->percentual_ajuste = abs($carteiraItem->percentual_ideal - $carteiraItem->percentual_na_carteira);

            $carteiraItem->tipo_ajuste = $valorAjuste > 0 ? 'comprar' : 'vender';
        });

        // Ordenar a posição atual por patrimônio em ordem decrescente e reindexar a coleção
        $posicaoAtual = $posicaoAtual->sortByDesc('valor_ajuste')->values();

        $posicaoAtualClasse = $posicaoAtual->groupBy('classe_ativo')->map(function ($item) {
            return $item->sum('percentual_na_carteira');
        });

        return Inertia::render('Admin/Rebalanceamento/Index', [
            'carteira' => $posicaoAtual,
            'posicaoAtualClasseKeys' => $posicaoAtualClasse->keys(),
            'posicaoAtualClasseValues' => $posicaoAtualClasse->values(),
            'posicaoIdealClasseKeys' => $rebalanceamentoClasseIdeal->keys(),
            'posicaoIdealClasseValues' => $rebalanceamentoClasseIdeal->values(),
        ]);
    }
}
