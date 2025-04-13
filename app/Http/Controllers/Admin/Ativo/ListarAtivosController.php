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
        $perPage = min($request->input('per_page', 10), 100);

        $query = Ativo::join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid')
            ->select('ativos.*', 'classes_ativos.nome as classe_nome');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('ativos.codigo', 'like', "%{$request->search}%")
                ->orWhere('ativos.nome', 'like', "%{$request->search}%")
                ->orWhere('classes_ativos.nome', 'like', "%{$request->search}%")
                ->orWhere('ativos.setor', 'like', "%{$request->search}%");
        }

        $ativos = $query->orderBy('ativos.codigo')
                       ->paginate($perPage)
                       ->withQueryString();

        $classes = ClasseAtivo::orderBy('nome')->get();

        return Inertia::render('Admin/Ativos/Index', [
            'ativos' => $ativos,
            'classes' => $classes
        ]);
    }
}
