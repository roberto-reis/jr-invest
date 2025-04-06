<?php

namespace App\Http\Controllers\Admin\Ativo;

use App\Models\Ativo;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAtivoRequest;

class UpdateAtivoController extends Controller
{
    public function __invoke(string $uid, UpdateAtivoRequest $request)
    {
        try {
            $ativo = Ativo::where('uid', $uid)->firstOrFail();

            $ativo->update($request->validated());

            return redirect()->route('ativos.index')
                            ->with('success', "Ativo '{$ativo->codigo}' atualizado com sucesso!");

        } catch (\Throwable $th) {
            return redirect()->route('ativos.index')
                            ->with('error', "Erro ao atualizar o ativo '{$request->codigo}'");
        }
    }
}
