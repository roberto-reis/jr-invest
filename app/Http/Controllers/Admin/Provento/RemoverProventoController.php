<?php

namespace App\Http\Controllers\Admin\Provento;

use App\Models\Provento;

class RemoverProventoController
{
    public function __invoke(string $uid)
    {
        try {
            $provento = Provento::where('uid', $uid)->with('ativo')->firstOrFail();

            $provento->delete();

            return redirect()->route('proventos.index')
            >with('success', "Provento do ativo {$provento->ativo->codigo} excluído com sucesso");
        } catch (\Exception $e) {
            return redirect()->route('proventos.index')
                    ->with('error', 'Erro ao excluir o provento');
        }
    }
}
