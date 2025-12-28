<?php

namespace App\Actions\Rebalanceamento;

use App\Models\RebalanceamentoAtivo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Actions\Portfolio\ListarPortifolioAction;

class ListarPosicaoAjusteAction
{
    public function __construct(
        public ListarPortifolioAction $listarPortifolioAction
    ){}

    public function execute(): Collection
    {
        // Calcular posição atual
        $posicaoAtual = $this->listarPortifolioAction->execute();
        $posicaoIdeal = RebalanceamentoAtivo::where('user_id', Auth::user()->id)->pluck('percentual', 'ativo_uid');

        $patrimonioTotal = $posicaoAtual->sum('patrimonio');

        $posicaoAtual->each(function ($carteiraItem) use ($posicaoIdeal, $patrimonioTotal) {
            $percentualIdeal = $posicaoIdeal->get($carteiraItem->ativo_uid, 0);

            $carteiraItem->percentual_ideal = $percentualIdeal;
            $carteiraItem->valor_ideal = $patrimonioTotal * ($carteiraItem->percentual_ideal / 100);

            // proteger divisão por zero caso cotacao_atual seja zero ou nula
            $cotacaoAtual = $carteiraItem->cotacao_atual ?? 0;
            $carteiraItem->quntidade_ideal = $cotacaoAtual > 0 ? $carteiraItem->valor_ideal / $cotacaoAtual : 0;

            $valorAjuste = $carteiraItem->valor_ideal - $carteiraItem->patrimonio;
            $carteiraItem->valor_ajuste = abs($valorAjuste);
            $carteiraItem->quantidade_ajuste = abs($carteiraItem->quntidade_ideal - ($carteiraItem->quantidade ?? 0));
            $carteiraItem->percentual_ajuste = abs($carteiraItem->percentual_ideal - ($carteiraItem->percentual_na_carteira ?? 0));

            $carteiraItem->tipo_ajuste = $valorAjuste > 0 ? 'comprar' : 'vender';
        });

        $posicaoAtual = $posicaoAtual->sortByDesc('valor_ajuste')->values();

        return $posicaoAtual;
    }
}
