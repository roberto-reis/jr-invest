<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\ConsolidaCarteiraEvent;
use App\Models\Operacao;
use App\Models\Carteira;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MontaCarteiraListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     */
    public function handle(ConsolidaCarteiraEvent $event): void
    {
        $operacoesAgrupadasAtivos = Operacao::query()
            ->where('user_id', $event->userId)
            ->get()
            ->groupBy('ativo_uid');

        $operacoesAgrupadasAtivos->each(function ($operacoes, $ativoUid) use ($event) {
            $somaOperacoesCompras = $operacoes->where('tipo_operacao', 'compra')->sum('quantidade');
            $somaOperacoesVendas = $operacoes->where('tipo_operacao', 'venda')->sum('quantidade');

            // Calculando a quantidade atual de ativos na carteira
            $quantidadeAtual = $somaOperacoesCompras - $somaOperacoesVendas;

            // Se não há mais ações deste ativo na carteira, removemos o registro
            if ($quantidadeAtual <= 0) {
                Carteira::where('user_id', $event->userId)
                    ->where('ativo_uid', $ativoUid)
                    ->delete();
                return;
            }

            // Calculando o preço médio apenas para operações de compra
            $operacoesCompra = $operacoes->where('tipo_operacao', 'compra');
            $precoMedio = $operacoesCompra->sum('valor_total') / $operacoesCompra->sum('quantidade');

            // Calculando o custo total atual (baseado no preço médio e quantidade atual)
            $custoTotal = $precoMedio * $quantidadeAtual;

            // Atualizando ou criando o registro na carteira
            Carteira::updateOrCreate(
                [
                    'user_id' => $event->userId,
                    'ativo_uid' => $ativoUid
                ],
                [
                    'quantidade' => $quantidadeAtual,
                    'preco_medio' => $precoMedio,
                    'custo_total' => $custoTotal
                ]
            );
        });
    }

    /**
     * Handle a job failure.
     */
    public function failed(ConsolidaCarteiraEvent $event, $exception): void
    {
        // Send user notification of failure, etc...
        Log::error('Erro ao montar carteira', [
            'user_id' => $event->userId,
            'exception' => $exception,
        ]);
    }
}
