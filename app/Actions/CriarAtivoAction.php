<?php

namespace App\Actions;

use App\Models\Ativo;

class CriarAtivoAction
{
    /**
     * Cria um novo ativo.
     *
     * @param array $data Os dados validados do ativo
     * @return Ativo O ativo recém-criado
     */
    public function execute(array $data): Ativo
    {
        // Cria o novo ativo
        return Ativo::create($data);
    }
}
