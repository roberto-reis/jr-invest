<?php

namespace App\Http\Controllers\Admin\Operacao;

use Inertia\Inertia;

class ListarOperacoesController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Operacoes/Index');
    }
}
