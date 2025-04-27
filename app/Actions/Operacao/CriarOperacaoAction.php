<?php

namespace App\Actions\Operacao;

use App\Models\Operacao;
use App\Events\ConsolidaCarteiraEvent;

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
        $operacao = Operacao::create($data);

        // Dispara o evento para atualizar a carteira
        event(new ConsolidaCarteiraEvent($operacao['user_id']));

        return $operacao;
    }
}
