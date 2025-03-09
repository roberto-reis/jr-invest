<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ListarPortfolioController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Admin/Portfolio/Index');
    }
}
