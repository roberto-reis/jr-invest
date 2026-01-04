<?php

namespace App\Jobs;

use Throwable;
use App\Models\Ativo;
use App\Models\Cotacao;
use Illuminate\Bus\Queueable;
use App\Services\HgBrasilApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SalvarAcoesEFIICotacaoHgBrasilJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Ativo $ativo;

    public int $tries = 3;
    public int $backoff = 60;

    /**
     * Create a new job instance.
     *
     * @param Ativo $ativo
     */
    public function __construct(Ativo $ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * Execute the job.
     */
    public function handle(HgBrasilApiService $hgBrasilApiService)
    {
        Log::info("Iniciando processamento de cotação para {$this->ativo->codigo}, tentativa: " . $this->attempts());

        $cotacaoResults = $hgBrasilApiService->getCotacoes($this->ativo->codigo);

        $this->processarCotacao($this->ativo, $cotacaoResults);
    }

    /**
     * Processa e salva a cotação de um ativo
     *
     * @param Ativo $ativo
     * @param array $cotacaoData
     * @return void
     */
    protected function processarCotacao(Ativo $ativo, array $cotacaoData)
    {
        if (empty($cotacaoData) || !is_array($cotacaoData)) {
            throw new \Exception("Dados da cotação inválidos ou vazios.");
        }

        $symbolKey = array_key_first($cotacaoData);
        $data = $cotacaoData[$symbolKey] ?? null;

        if (!$symbolKey || !is_array($data) || !isset($data['price'])) {
            throw new \Exception("Dados da cotação incompletos: 'price' ausente.");
        }

        Cotacao::create([
            'ativo_uid' => $ativo->uid,
            'moeda_ref' => $data['currency'] ?? 'BRL',
            'preco' => $data['price'],
        ]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Erro ao processar cotação', [
            'exception' => $exception
        ]);
    }
}
