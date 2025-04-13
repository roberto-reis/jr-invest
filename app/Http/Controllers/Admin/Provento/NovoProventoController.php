<?php

namespace App\Http\Controllers\Admin\Provento;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\NovoProventoRequest;
use App\Actions\Provento\CriarProventoAction;

class NovoProventoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(NovoProventoRequest $request, CriarProventoAction $action)
    {
        try {
            // dd($request->validated());
            $action->execute($request->validated());

            // Redireciona para a página de listagem de ativos com mensagem de sucesso
            return Redirect::route('proventos.index')
                ->with('success', "Provento cadastrado com sucesso!");

        } catch (\Throwable $th) {
            return redirect()->route('proventos.index')
                            ->with('error', "Erro ao cadastrar o provento");
        }
    }
}
