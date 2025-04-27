<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Inertia\Inertia;
use App\Models\Operacao;
use App\Models\Provento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Portfolio\ListarPortifolioAction;

class DashboardController
{

    public function __invoke(ListarPortifolioAction $listarPortifolioAction)
    {
        // Pegar as 10 ultimas operações
        $operacoes = Operacao::where('user_id', Auth::user()->id)
            ->select(
                'operacoes.*',
                'ativos.codigo as ativo_codigo',
                'tipos_operacoes.nome as tipo_operacao_nome',
                'classes_ativos.nome as classe_nome'
            )
            ->joinAtivo()
            ->joinClasseAtivo()
            ->joinTipoOperacao()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();


        $carteira = $listarPortifolioAction->execute();
        $carteiraTotalPercentual = $carteira->groupBy('classe_ativo')->map(function ($ativos) {
            return $ativos->sum('percentual_na_carteira');
        });

        // Pegar dividendos e proventos, agrupados por mês para o gráfico
        $proventosPorMes = Provento::where('user_id', Auth::user()->id)
            ->whereYear('data_pagamento', date('Y'))
            ->selectRaw('MONTH(data_pagamento) as num_mes, SUM(valor * quantidade_ativo) as total')
            ->groupBy('num_mes')
            ->orderBy('num_mes')
            ->get();

        $dadosProventos = [];
        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        foreach ($proventosPorMes as $provento) {
            $nomeMes = $meses[$provento->num_mes - 1];
            $dadosProventos[$nomeMes] = $provento->total;
        }

        return Inertia::render('Admin/Dashboard/Index', [
            'operacoes' => $operacoes,
            'carteiraTotalPercentual' => $carteiraTotalPercentual,
            'proventos' => [
                'labels' => array_keys($dadosProventos),
                'data' => array_values($dadosProventos),
            ],
        ]);
    }
}
