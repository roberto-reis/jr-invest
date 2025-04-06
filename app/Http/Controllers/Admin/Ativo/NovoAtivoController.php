<?php

namespace App\Http\Controllers\Admin\Ativo;

use App\Actions\CriarAtivoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CriarAtivoRequest;
use Illuminate\Support\Facades\Redirect;

class NovoAtivoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CriarAtivoRequest $request, CriarAtivoAction $action)
    {
        // Obter dados validados e criar o ativo usando a action
        $ativo = $action->execute($request->validated());

        // Redireciona para a página de listagem de ativos com mensagem de sucesso
        return Redirect::route('ativos.index')
            ->with('success', "Ativo {$ativo->codigo} cadastrado com sucesso!");
    }
}
