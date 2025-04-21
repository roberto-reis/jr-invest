<?php

namespace App\Actions\Rebalanceamento;

use App\Models\RebalanceamentoAtivo;
use App\Exceptions\RebalanceamentoException;

class AtualizarRebalanceamentoAtivoAction
{
    public function execute(array $data, string $uid)
    {
        // Validar a classe o percentual não pode atingir maior 100%
        $percentualTotal = RebalanceamentoAtivo::where('user_id', $data['user_id'])
                ->where('uid', '!=', $uid)
                ->sum('percentual');

        if ($percentualTotal + $data['percentual'] > 100) {
            throw new RebalanceamentoException('O percentual total não pode atingir maior 100%');
        }

        return RebalanceamentoAtivo::where('uid', $uid)->update($data);
    }
}
