<?php

namespace App\Http\Controllers\Admin\Rebalanceamento;

use Inertia\Inertia;
use App\Models\Ativo;
use App\Models\ClasseAtivo;
use App\Models\RebalanceamentoAtivo;
use App\Models\RebalanceamentoClasse;

class ListarConfigRebalanceamentoController
{
    public function __invoke()
    {
        $rebalanceamentoClasses = RebalanceamentoClasse::select(
                'rebalanceamento_classes.*',
                'classes_ativos.nome as classe_nome'
            )
            ->join('classes_ativos', 'rebalanceamento_classes.classe_ativo_uid', '=', 'classes_ativos.uid')
            ->get();

        $rebalanceamentoAtivos = RebalanceamentoAtivo::select(
                'rebalanceamento_ativos.*',
                'ativos.codigo as ativo_codigo',
                'classes_ativos.nome as classe_nome'
            )
            ->join('ativos', 'rebalanceamento_ativos.ativo_uid', '=', 'ativos.uid')
            ->join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid')
            ->get();

        $classeAtivos = ClasseAtivo::get();
        $ativos = Ativo::get();

        return Inertia::render('Admin/Rebalanceamento/Config', [
            'rebalanceamentoClasses' => $rebalanceamentoClasses,
            'rebalanceamentoAtivos' => $rebalanceamentoAtivos,
            'classeAtivos' => $classeAtivos,
            'ativos' => $ativos,
        ]);
    }
}
