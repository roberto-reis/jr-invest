<?php

namespace App\Actions\Rebalanceamento;

use App\Models\RebalanceamentoAtivo;
use App\Exceptions\RebalanceamentoException;

class NovoRebalanceamentoAtivoAction
{
    public function execute(array $data)
    {
        // Verificar se ativo já existe percentual
        $ativo = RebalanceamentoAtivo::where('user_id', $data['user_id'])->where('ativo_uid', $data['ativo_uid'])->first();
        if ($ativo) {
            throw new RebalanceamentoException('Ativo já existe percentual: ' . $ativo->percentual . '%');
        }

        // Validar a classe o percentual não pode atingir maior 100%
        $percentualTotal = RebalanceamentoAtivo::where('user_id', $data['user_id'])->sum('percentual');

        if ($percentualTotal + $data['percentual'] > 100) {
            throw new RebalanceamentoException('O percentual total não pode atingir maior 100%');
        }


        return RebalanceamentoAtivo::create($data);
    }
}
