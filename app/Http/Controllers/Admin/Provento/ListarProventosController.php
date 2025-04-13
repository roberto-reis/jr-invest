<?php

namespace App\Http\Controllers\Admin\Provento;

use Inertia\Inertia;
use App\Models\Ativo;
use App\Models\Provento;
use App\Models\Corretora;
use App\Models\TipoProvento;
use Illuminate\Http\Request;

class ListarProventosController
{
    public function __invoke(Request $request)
    {
        $query = Provento::select(
                        'proventos.*',
                        'ativos.codigo as ativo_codigo',
                        'tipos_proventos.nome as tipo_provento_nome',
                        'corretoras.nome as corretora_nome'
                    )
                    ->join('ativos', 'proventos.ativo_uid', '=', 'ativos.uid')
                    ->join('tipos_proventos', 'proventos.tipo_provento_uid', '=', 'tipos_proventos.uid')
                    ->join('corretoras', 'proventos.corretora_uid', '=', 'corretoras.uid')
                    ->orderBy('data_pagamento', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('ativos.codigo', 'like', "%{$request->search}%")
                ->orWhere('tipos_proventos.nome', 'like', "%{$request->search}%")
                ->orWhere('corretoras.nome', 'like', "%{$request->search}%")
                ->orWhere('quantidade_ativo', 'like', "%{$request->search}%")
                ->orWhere('valor', 'like', "%{$request->search}%")
                ->orWhere('yield_on_cost', 'like', "%{$request->search}%")
                ->orWhere('data_pagamento', 'like', "%{$request->search}%")
                ->orWhere('data_com', 'like', "%{$request->search}%");
        }

        $proventos = $query->paginate(min($request->input('per_page', 10), 100))
                        ->withQueryString();

        $ativos = Ativo::orderBy('codigo')->get();
        $tiposProventos = TipoProvento::orderBy('nome_interno')->get();
        $corretoras = Corretora::orderBy('nome_interno')->get();

        return Inertia::render('Admin/Proventos/Index', [
            'proventos' => $proventos,
            'ativos' => $ativos,
            'tiposProventos' => $tiposProventos,
            'corretoras' => $corretoras
        ]);
    }
}
