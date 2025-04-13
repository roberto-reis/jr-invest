<?php

namespace App\Http\Controllers\Admin\Provento;

use App\Models\Provento;
use App\Http\Requests\NovoProventoRequest;

class UpdateProventoController
{
    public function __invoke(string $uid, NovoProventoRequest $request)
    {
        try {
            $provento = Provento::where('uid', $uid)->firstOrFail();

            $provento->update($request->validated());

            return redirect()->route('proventos.index')
                            ->with('success', "Provento atualizado com sucesso!");

        } catch (\Throwable $th) {
            return redirect()->route('proventos.index')
                            ->with('error', "Erro ao atualizar o provento");
        }
    }
}
