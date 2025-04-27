<?php

namespace App\Http\Controllers\Admin\Dashboard;

use Inertia\Inertia;
use App\Models\Operacao;
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

        return Inertia::render('Admin/Dashboard/Index', [
            'operacoes' => $operacoes,
            'carteiraTotalPercentual' => $carteiraTotalPercentual,
        ]);
    }
}
