<?php

namespace App\Actions\Rebalanceamento;

use App\Models\RebalanceamentoClasse;
use App\Exceptions\RebalanceamentoException;

class NovoRebalanceamentoClasseAction
{
    public function execute(array $data)
    {
        // Validar a classe o percentual não pode atingir maior 100%
        $percentualTotal = RebalanceamentoClasse::where('user_id', $data['user_id'])->sum('percentual');

        if ($percentualTotal + $data['percentual'] > 100) {
            throw new RebalanceamentoException('O percentual total não pode atingir maior 100%');
        }


        return RebalanceamentoClasse::create($data);
    }
}
