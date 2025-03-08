<?php

namespace App\Http\Controllers\Admin\Ativo;

use Inertia\Inertia;

class ListarAtivosController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Ativos/Index');
    }
}
