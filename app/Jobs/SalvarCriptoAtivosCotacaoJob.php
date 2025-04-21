<?php

namespace App\Jobs;

use Throwable;
use App\Models\Cotacao;
use Illuminate\Bus\Queueable;
use App\Services\BrApiService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SalvarCriptoAtivosCotacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Collection $ativos;

    protected int $sizeChunk = 10; // brapi aceita somente 10 ativos por requisição

    public int $tries = 3;

    public int $backoff = 60; // Tempo de espera entre tentativas em segundos

    /**
     * Create a new job instance.
     *
     * @param Collection $ativos Coleção de criptoativos
     */
    public function __construct(Collection $ativos)
    {
        $this->ativos = $ativos;
    }

    /**
     * Execute the job.
     */
    public function handle(BrApiService $brApiService)
    {
        Log::info("Iniciando processamento de cotações de criptoativos, tentativa: " . $this->attempts());

        $this->ativos->chunk($this->sizeChunk)->each(function ($loteAtivos) use ($brApiService) {
            $codigos = $loteAtivos->pluck('codigo')->toArray();

            $cotacoes = $brApiService->getCriptoCotacoes($codigos);

            foreach ($cotacoes as $cotacao) {
                $this->processarCotacao($loteAtivos, $cotacao);
            }
        });
    }



    /**
     * Processa e salva a cotação de um criptoativo
     *
     * @param Collection $ativos
     * @param array $cotacaoData
     * @return void
     */
    protected function processarCotacao(Collection $ativos, array $cotacaoData)
    {
        if (!isset($cotacaoData['coin']) || !isset($cotacaoData['regularMarketPrice'])) {
            throw new \Exception("Dados da cotação incompletos: 'coin' ou 'regularMarketPrice' ausente.");
        }

        $ativo = $ativos->firstWhere('codigo', $cotacaoData['coin']);

        Cotacao::create([
            'ativo_uid' => $ativo->uid,
            'moeda_ref' => $cotacaoData['currency'] ?? 'BRL',
            'preco' => $cotacaoData['regularMarketPrice'],
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('Erro ao processar cotação de criptoativos', [
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
