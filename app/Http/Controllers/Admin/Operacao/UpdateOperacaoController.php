<?php

namespace App\Http\Controllers\Admin\Operacao;

use App\Models\Operacao;
use App\Http\Controllers\Controller;
use App\Events\ConsolidaCarteiraEvent;
use App\Http\Requests\UpdateOperacaoRequest;

class UpdateOperacaoController extends Controller
{
    public function __invoke(string $uid, UpdateOperacaoRequest $request)
    {
        try {
            $operacao = Operacao::where('uid', $uid)->firstOrFail();

            $operacao->update($request->validated());

                    // Dispara o evento para atualizar a carteira
            event(new ConsolidaCarteiraEvent($operacao['user_id']));

            return redirect()->route('operacoes.index')
                            ->with('success', "Operação atualizada com sucesso!");

        } catch (\Throwable $th) {
            return redirect()->route('operacoes.index')
                            ->with('error', "Erro ao atualizar a operação");
        }
    }
}
