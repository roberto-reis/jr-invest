<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Inertia\Inertia;

class ListarRebalanceamentoController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Rebalanceamento/Index', []);
    }
}
