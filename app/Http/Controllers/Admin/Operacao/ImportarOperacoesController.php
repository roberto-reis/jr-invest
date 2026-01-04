<?php

namespace App\Http\Controllers\Admin\Operacao;

use App\Actions\Operacao\ImportarOperacoesAction;
use Illuminate\Http\Request;

class ImportarOperacoesController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ImportarOperacoesAction $action)
    {
        $dadoValidado = $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'], // 10MB Max
        ]);

        $action->execute(
            $dadoValidado['file'],
            $request->user()->id
        );

        return back()->with('success', 'Importação concluída com sucesso!');
    }
}
