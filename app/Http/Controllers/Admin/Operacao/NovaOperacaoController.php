<?php

namespace App\Http\Controllers\Admin\Operacao;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CriarOperacaoRequest;
use App\Actions\Operacao\CriarOperacaoAction;

class NovaOperacaoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CriarOperacaoRequest $request, CriarOperacaoAction $action)
    {
        try {
            $action->execute($request->validated());

            // Redireciona para a página de listagem de ativos com mensagem de sucesso
            return Redirect::route('operacoes.index')
                ->with('success', "Operação cadastrada com sucesso!");

        } catch (\Throwable $th) {
            return redirect()->route('operacoes.index')
                            ->with('error', "Erro ao cadastrar a operação");
        }
    }
}
