<?php

namespace App\Http\Controllers\Admin\Portfolio;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Actions\Portfolio\ListarPortifolioAction;

class ListarPortfolioController extends Controller
{
    public function __invoke(ListarPortifolioAction $action)
    {
        $carteira = $action->execute();

        return Inertia::render('Admin/Portfolio/Index', [
            'carteira' => $carteira,
        ]);
    }
}
