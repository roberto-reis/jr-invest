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
        // Get the per_page parameter with a default of 10
        $perPage = $request->input('per_page', 10);

        $query = Ativo::join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid')
            ->select('ativos.*', 'classes_ativos.nome as classe_nome');

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ativos.codigo', 'like', "%{$search}%")
                  ->orWhere('ativos.nome', 'like', "%{$search}%")
                  ->orWhere('classes_ativos.nome', 'like', "%{$search}%")
                  ->orWhere('ativos.setor', 'like', "%{$search}%");
            });
        }

        // Get paginated results
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
