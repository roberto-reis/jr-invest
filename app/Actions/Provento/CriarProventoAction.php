<?php

namespace App\Actions\Provento;

use App\Models\Provento;

class CriarProventoAction
{
    /**
     * Cria uma nova operação.
     *
     * @param array $data Os dados validados da operação
     * @return Operacao A operação recém-criada
     */
    public function execute(array $data): Provento
    {
        // Pegar o valor total do ativo
        // Calcular yield on cost
        $yieldOnCost = 0; // Por enquanto é mock
        $data['yield_on_cost'] = $yieldOnCost;

        return Provento::create($data);
    }
}
