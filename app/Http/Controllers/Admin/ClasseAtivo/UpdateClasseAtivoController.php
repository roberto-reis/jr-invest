<?php

namespace App\Http\Controllers\Admin\ClasseAtivo;

use App\Models\ClasseAtivo;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClasseAtivoRequest;

class UpdateClasseAtivoController extends Controller
{
    public function __invoke(string $uid, UpdateClasseAtivoRequest $request)
    {
        $classeAtivo = ClasseAtivo::where('uid', $uid)->firstOrFail();

        $classeAtivo->update($request->validated());

        return redirect()->route('classes-ativos.index')
                        ->with('success', "Classe '{$classeAtivo->nome}' atualizada com sucesso!");
    }
}
