<?php

namespace App\Http\Controllers\Admin\Ativos;

use Inertia\Inertia;

class ListarController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Ativos/Index');
    }
}
