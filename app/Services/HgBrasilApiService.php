<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HgBrasilApiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.hgbrasil.url');
        $this->apiKey = config('services.hgbrasil.token');
    }

    /**
     * Busca cotações de ações e FIIs na API HgBrasil
     *
     * @param array|string $ativos Array de códigos de ativos (ex: ['PETR4', 'BBAS3', 'HGLG11'])
     * @return array|null Array com as cotações ou null em caso de erro
     */
    public function getCotacoes(array|string $ativos)
    {
        $ativosImploded = is_array($ativos) ? implode(',', $ativos) : $ativos;
        $endpoint = "finance/stock_price?symbol={$ativosImploded}&key={$this->apiKey}";

        $response = Http::get($this->baseUrl . $endpoint);

        $response->throw();

        return $response->json('results');
    }
}
