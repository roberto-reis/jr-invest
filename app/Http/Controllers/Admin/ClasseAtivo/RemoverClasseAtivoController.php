<?php

namespace App\Http\Controllers\Admin\ClasseAtivo;

use App\Models\ClasseAtivo;

class RemoverClasseAtivoController
{
    public function __invoke(string $uid)
    {
        $classeAtivo = ClasseAtivo::where('uid', $uid)->firstOrFail();

        $classeAtivo->delete();

        return redirect()->route('classes-ativos.index')
                        ->with('success', "Classe '{$classeAtivo->nome}' removida com sucesso!");
    }
}
