<?php

namespace App\Http\Controllers\Admin\ClasseAtivo;

use App\Models\ClasseAtivo;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CriarClasseAtivoRequest;

class NovaClasseAtivoController extends Controller
{
    public function __invoke(CriarClasseAtivoRequest $request)
    {
        $validated = $request->validated();

        ClasseAtivo::create($validated);

        // Certifique-se de usar 'success' como a chave da mensagem flash
        return redirect()->route('classes-ativos.index')
            ->with('success', "Classe de ativo criada com sucesso!");
    }
}
