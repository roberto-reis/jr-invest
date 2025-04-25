<?php

namespace App\Http\Controllers\Admin\Portfolio;

use Inertia\Inertia;
use App\Models\Carteira;
use App\Http\Controllers\Controller;
use App\Models\Cotacao;
use Illuminate\Support\Facades\Auth;

class ListarPortfolioController extends Controller
{
    public function __invoke()
    {
        // Pegar cotaçõe por data
        $cotacoes = Cotacao::where('created_at', '>=', now()->subDays(1))->get();
        $carteira = Carteira::select('carteiras.*', 'ativos.codigo AS codigo_ativo', 'classes_ativos.nome AS classe_ativo')
            ->join('ativos', 'ativos.uid', '=', 'carteiras.ativo_uid')
            ->join('classes_ativos', 'classes_ativos.uid', '=', 'ativos.classe_ativo_uid')
            ->where('user_id', Auth::id())->get();

        if ($cotacoes->isEmpty()) throw new \Exception("Sem dados de cotações");

        // Calcula patrimonio por ativo
        $carteira->each(function ($carteiraItem) use ($cotacoes) {
            $cotacao = $cotacoes->firstWhere('ativo_uid', $carteiraItem->ativo_uid);
            if ($cotacao) {
                $carteiraItem->cotacao_atual = $cotacao->preco;
                $carteiraItem->patrimonio = $carteiraItem->quantidade * $cotacao->preco;
            }
        });

        // Calcula patrimonio total
        $patrimonioTotal = $carteira->sum('patrimonio');

        // Calcular percentual na carteira e por classe
        $carteira->groupBy('classe_ativo')->each(function ($ativos) use ($patrimonioTotal) {
            $somaTotalPorClasse = $ativos->sum('patrimonio');

            $ativos->each(function ($carteiraItem) use ($patrimonioTotal, $somaTotalPorClasse) {
                $carteiraItem->percentual_na_carteira = ($carteiraItem->patrimonio / $patrimonioTotal) * 100;
                $carteiraItem->percentual_classe = ($carteiraItem->patrimonio / $somaTotalPorClasse) * 100;
            });

        });

        return Inertia::render('Admin/Portfolio/Index', [
            'carteira' => $carteira,
        ]);
    }
}
