<?php

namespace App\Http\Controllers\Admin\Ativo;

use App\Models\Ativo;

class RemoverAtivoController
{
    public function __invoke(string $uid)
    {
        try {
            $ativo = Ativo::where('uid', $uid)->firstOrFail();

            $ativo->delete();

            return redirect()->route('ativos.index')
                            ->with('success', "Ativo '{$ativo->codigo}' removido com sucesso!");

        } catch (\Throwable $th) {
            $ativoError = $ativo->codigo ?? $uid;
            return redirect()->route('ativos.index')
                            ->with('error', "Erro ao excluir o ativo '{$ativoError}'");
        }
    }
}
