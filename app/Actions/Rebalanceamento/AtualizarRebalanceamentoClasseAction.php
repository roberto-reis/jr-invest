<?php

namespace App\Actions\Rebalanceamento;

use App\Models\RebalanceamentoClasse;
use App\Exceptions\RebalanceamentoException;

class AtualizarRebalanceamentoClasseAction
{
    public function execute(array $data, string $uid)
    {
        $percentualTotal = RebalanceamentoClasse::query()
            ->where('user_id', $data['user_id'])
            ->where('uid', '!=', $uid)
            ->sum('percentual');

        if ($percentualTotal + $data['percentual'] > 100) {
            throw new RebalanceamentoException('O percentual total não pode atingir maior 100%');
        }

        return RebalanceamentoClasse::where('uid', $uid)->update($data);
    }
}
