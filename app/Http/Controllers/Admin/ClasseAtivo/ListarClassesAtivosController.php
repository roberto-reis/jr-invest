<?php

namespace App\Http\Controllers\Admin\ClasseAtivo;

use App\Http\Controllers\Controller;
use App\Models\ClasseAtivo;
use Inertia\Inertia;

class ListarClassesAtivosController extends Controller
{
    public function __invoke()
    {
        $classes = ClasseAtivo::orderBy('nome')->get();

        return Inertia::render('Admin/ClassesAtivos/Index', [
            'classes' => $classes
        ]);
    }
}
