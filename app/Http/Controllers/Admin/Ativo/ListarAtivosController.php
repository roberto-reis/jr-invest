<?php

namespace App\Http\Controllers\Admin\Ativo;

use Inertia\Inertia;
use App\Models\Ativo;
use App\Models\ClasseAtivo;
use Illuminate\Http\Request;

class ListarAtivosController
{
    public function __invoke(Request $request)
    {
        $ativos = Ativo::join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid')
            ->select('ativos.*', 'classes_ativos.nome as classe_nome')
            ->where('ativos.codigo', 'like', '%' . $request->input('search') . '%')
            ->orWhere('ativos.nome', 'like', '%' . $request->input('search') . '%')
            ->orWhere('classes_ativos.nome', 'like', '%' . $request->input('search') . '%')
            ->orWhere('ativos.setor', 'like', '%' . $request->input('search') . '%')
            ->orderBy('ativos.codigo')
            ->get();

        $classes = ClasseAtivo::orderBy('nome')->get();

        return Inertia::render('Admin/Ativos/Index', [
            'ativos' => $ativos,
            'classes' => $classes
        ]);
    }
}
