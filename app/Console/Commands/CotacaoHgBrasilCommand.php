<?php

namespace App\Console\Commands;

use App\Models\ClasseAtivo;
use Illuminate\Console\Command;
use App\Jobs\SalvarAcoesEFIICotacaoHgBrasilJob;
use App\Jobs\SalvarCriptoAtivosCotacaoJob;

class CotacaoHgBrasilCommand extends Command
{
    protected $signature = 'ativos:cotacao-hgbrasil';
    protected $description = 'Atualiza as cotações dos ativos (Ações, FII e criptomoedas)';

    public function handle()
    {
        $classesAtivos = ClasseAtivo::with('ativos')
                                    ->has('ativos')
                                    ->get();

        if ($classesAtivos->isEmpty()) {
            throw new \Exception("Não há classes com ativos disponíveis.");
        }

        foreach ($classesAtivos as $classeAtivo) {
            switch ($classeAtivo->nome_interno) {
                case 'acoes':
                case 'fii':
                    foreach ($classeAtivo->ativos as $ativo) {
                        SalvarAcoesEFIICotacaoHgBrasilJob::dispatch($ativo);
                    }
                    break;
                case 'cripto':
                case 'stablecoin':
                    foreach ($classeAtivo->ativos as $ativo) {
                        SalvarCriptoAtivosCotacaoJob::dispatch($ativo);
                    }
                    break;
            }
        }
    }
}
