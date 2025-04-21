<?php

namespace App\Actions\Rebalanceamento;

use App\Models\RebalanceamentoAtivo;
use App\Exceptions\RebalanceamentoException;

class NovoRebalanceamentoAtivoAction
{
    public function execute(array $data)
    {
        // Validar a classe o percentual não pode atingir maior 100%
        $percentualTotal = RebalanceamentoAtivo::where('user_id', $data['user_id'])->sum('percentual');

        if ($percentualTotal + $data['percentual'] > 100) {
            throw new RebalanceamentoException('O percentual total não pode atingir maior 100%');
        }


        return RebalanceamentoAtivo::create($data);
    }
}
