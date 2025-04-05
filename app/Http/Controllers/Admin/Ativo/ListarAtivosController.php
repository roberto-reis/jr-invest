<?php

namespace App\Http\Controllers\Admin\Ativo;

use Inertia\Inertia;
use App\Models\Ativo;
use App\Models\ClasseAtivo;

class ListarAtivosController
{
    public function __invoke()
    {
        $ativos = Ativo::join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid')
            ->select('ativos.*', 'classes_ativos.nome as classe_nome')
            ->orderBy('ativos.codigo')
            ->get();

        $classes = ClasseAtivo::orderBy('nome')->get();

        return Inertia::render('Admin/Ativos/Index', [
            'ativos' => $ativos,
            'classes' => $classes
        ]);
    }
}
