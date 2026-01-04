<?php

namespace App\Actions\Rebalanceamento;

use App\Models\RebalanceamentoAtivo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Actions\Portfolio\ListarPortifolioAction;
use App\Models\Cotacao;

class ListarPosicaoAjusteAction
{
    public function __construct(
        public ListarPortifolioAction $listarPortifolioAction
    ){}

    public function execute(): Collection
    {
        $cotacoes = Cotacao::where('created_at', '>=', now()->subDays(3))->get();
        if ($cotacoes->isEmpty()) throw new \Exception("Sem dados de cotações");

        // Calcular posição atual
        $posicaoAtual = $this->listarPortifolioAction->execute();

        $posicaoIdeal = RebalanceamentoAtivo::select('rebalanceamento_ativos.*', 'ativos.codigo AS codigo_ativo', 'classes_ativos.nome AS classe_ativo')
            ->join('ativos', 'ativos.uid', '=', 'rebalanceamento_ativos.ativo_uid')
            ->join('classes_ativos', 'classes_ativos.uid', '=', 'ativos.classe_ativo_uid')
            ->where('user_id', Auth::id())->get();

        $patrimonioTotal = $posicaoAtual->sum('patrimonio');

        $posicaoAtual->each(function ($carteiraItem) use ($posicaoIdeal, $patrimonioTotal, $cotacoes) {
            $percentualIdeal = $posicaoIdeal->firstWhere('ativo_uid', $carteiraItem->ativo_uid)?->percentual ?? 0;
            $cotacaoAtual = $cotacoes->firstWhere('ativo_uid', $carteiraItem->ativo_uid)?->preco ?? 0;

            $carteiraItem->percentual_ideal = $percentualIdeal;
            $carteiraItem->valor_ideal = $patrimonioTotal * ($carteiraItem->percentual_ideal / 100);

            // proteger divisão por zero caso cotacao_atual seja zero ou nula
            $carteiraItem->quntidade_ideal = $cotacaoAtual > 0 ? $carteiraItem->valor_ideal / $cotacaoAtual : 0;

            $valorAjuste = $carteiraItem->valor_ideal - $carteiraItem->patrimonio;
            $carteiraItem->valor_ajuste = abs($valorAjuste);
            $carteiraItem->quantidade_ajuste = abs($carteiraItem->quntidade_ideal - ($carteiraItem->quantidade ?? 0));
            $carteiraItem->percentual_ajuste = abs($carteiraItem->percentual_ideal - ($carteiraItem->percentual_na_carteira ?? 0));

            $carteiraItem->tipo_ajuste = $valorAjuste > 0 ? 'comprar' : 'vender';
        });

        // Calcular o ativos que estão no ideal mas não na carteira
        $posicaoIdeal->each(function ($idealItem) use ($posicaoAtual, $patrimonioTotal, $cotacoes) {
            $carteiraItem = $posicaoAtual->firstWhere('ativo_uid', $idealItem->ativo_uid);
            if (!$carteiraItem) {
                $cotacaoAtual = $cotacoes->firstWhere('ativo_uid', $idealItem->ativo_uid)?->preco ?? 0;
                $valorIdeal = $patrimonioTotal * ($idealItem->percentual / 100);
                $quntidadeIdeal = $cotacaoAtual > 0 ? $valorIdeal / $cotacaoAtual : 0;
                $valorAjuste = $valorIdeal;
                $quantidadeAjuste = abs($quntidadeIdeal);
                $percentualAjuste = abs($idealItem->percentual);
                $posicaoAtual->push((object)[
                    'ativo_uid' => $idealItem->ativo_uid,
                    'codigo_ativo' => $idealItem->codigo_ativo,
                    'classe_ativo' => $idealItem->classe_ativo,
                    'cotacao_atual' => $cotacaoAtual,
                    'patrimonio' => 0,
                    'quantidade' => 0,
                    'percentual_na_carteira' => 0,
                    'percentual_ideal' => $idealItem->percentual,
                    'valor_ideal' => $valorIdeal,
                    'quntidade_ideal' => $quntidadeIdeal,
                    'valor_ajuste' => $valorAjuste,
                    'quantidade_ajuste' => $quantidadeAjuste,
                    'percentual_ajuste' => $percentualAjuste,
                    'tipo_ajuste' => 'comprar',
                ]);
            }
        });

        $posicaoAtual = $posicaoAtual->sortByDesc('valor_ajuste')->values();

        return $posicaoAtual;
    }
}
