<?php

namespace App\Http\Controllers\Admin\Operacao;

use App\Models\Operacao;

class RemoverOperacaoController
{
    public function __invoke(string $uid)
    {
        try {
            $operacao = Operacao::where('uid', $uid)->firstOrFail();

            $operacao->delete();

            return redirect()->route('operacoes.index')
                            ->with('success', "Operação '{$operacao->uid}' removida com sucesso!");

        } catch (\Throwable $th) {
            $operacaoError = $operacao->uid ?? $uid;
            return redirect()->route('operacoes.index')
                            ->with('error', "Erro ao excluir a operação '{$operacaoError}'");
        }
    }
}
