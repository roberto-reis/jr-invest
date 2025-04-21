<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BrApiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.brapi.url', 'https://brapi.dev/api');
        $this->apiKey = config('services.brapi.key');
    }

    /**
     * Busca cotações de ações e FIIs na API BrAPI
     *
     * @param array $symbols Array de códigos de ativos (ex: ['PETR4', 'BBAS3', 'HGLG11'])
     * @return array|null Array com as cotações ou null em caso de erro
     */
    public function getCotacoes(array $ativos)
    {
        $ativosImploded = implode(',', $ativos);
        $endpoint = "/quote/{$ativosImploded}";

        $params = ['token' => $this->apiKey];

        $response = Http::get($this->baseUrl . $endpoint, $params);

        $response->throw();

        return $response->json('results');
    }

    /**
     * Busca cotações de criptoativos na API BrAPI
     *
     * @param array $symbols Array de códigos de criptoativos (ex: ['BTC', 'ETH', 'XRP'])
     * @return array Array com as cotações
     */
    public function getCriptoCotacoes(array $symbols)
    {
        $symbolsImploded = implode(',', $symbols);
        $endpoint = "/v2/crypto?coin={$symbolsImploded}";

        $params = ['token' => $this->apiKey];

        $response = Http::get($this->baseUrl . $endpoint, $params);

        $response->throw();

        return $response->json('coins') ?? [];
    }

    /**
     * Busca informações detalhadas de um ativo específico
     *
     * @param string $symbol Código do ativo (ex: 'PETR4')
     * @return array|null Array com as informações ou null em caso de erro
     */
    public function getAtivoInfo(string $symbol)
    {
        $endpoint = "/quote/{$symbol}";

        $params = ['token' => $this->apiKey];

        $response = Http::get($this->baseUrl . $endpoint, $params);

        $response->throw();

        return $response->json('results')[0];
    }
}