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

        return $posicaoAtual;
    }
}
