<?php

namespace App\Console\Commands;

use App\Jobs\SalvarAcoesEFIICotacaoJob;
use App\Models\ClasseAtivo;
use Illuminate\Console\Command;

class CotacaoCammand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ativos:cotacao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza as cotações dos ativos (Ações, FII e criptomoedas)';

    /**
     * Execute the console command.
     */
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
                    SalvarAcoesEFIICotacaoJob::dispatch($classeAtivo->ativos);
                    break;
                case 'cripto':
                case 'stablecoin':
                    // SalvarCriptoAtivosCotacaoJob::dispatch($classeAtivo->ativos);
                    break;
            }
        }
    }
}
