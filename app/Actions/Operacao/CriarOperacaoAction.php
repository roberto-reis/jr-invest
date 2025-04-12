<?php

namespace App\Actions\Operacao;

use App\Models\Operacao;

class CriarOperacaoAction
{
    /**
     * Cria uma nova operação.
     *
     * @param array $data Os dados validados da operação
     * @return Operacao A operação recém-criada
     */
    public function execute(array $data): Operacao
    {
        return Operacao::create($data);
    }
}
