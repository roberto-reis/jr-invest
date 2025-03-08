<?php

namespace App\Http\Controllers\Admin\Provento;

use Inertia\Inertia;

class ListarProventosController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Proventos/Index');
    }
}
