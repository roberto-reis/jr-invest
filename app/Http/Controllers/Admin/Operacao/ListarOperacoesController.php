<?php

namespace App\Http\Controllers\Admin\Operacao;

use Inertia\Inertia;
use App\Models\Ativo;
use App\Models\Operacao;
use App\Models\Corretora;
use App\Models\TipoOperacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListarOperacoesController
{
    public function __invoke(Request $request)
    {
        // Pegar a classe ativa tambem
        $query = Operacao::where('user_id', Auth::user()->id)
            ->select(
                'operacoes.*',
                'ativos.codigo as ativo_codigo',
                'tipos_operacoes.nome as tipo_operacao_nome',
                'corretoras.nome as corretora_nome',
                'classes_ativos.nome as classe_nome'
            )
            ->join('ativos', 'operacoes.ativo_uid', '=', 'ativos.uid')
            ->join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid')
            ->join('tipos_operacoes', 'operacoes.tipo_operacao_uid', '=', 'tipos_operacoes.uid')
            ->join('corretoras', 'operacoes.corretora_uid', '=', 'corretoras.uid')
            ->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('ativos.codigo', 'like', "%{$request->search}%")
                ->orWhere('tipos_operacoes.nome', 'like', "%{$request->search}%")
                ->orWhere('corretoras.nome', 'like', "%{$request->search}%")
                ->orWhere('classes_ativos.nome', 'like', "%{$request->search}%")
                ->orWhere('operacoes.quantidade', 'like', "%{$request->search}%")
                ->orWhere('operacoes.cotacao_preco', 'like', "%{$request->search}%");
        }

        $operacoes = $query->paginate(min($request->input('per_page', 10), 100))
                        ->withQueryString();

        $ativos = Ativo::orderBy('created_at', 'asc')->get();
        $corretoras = Corretora::orderBy('created_at', 'asc')->get();
        $tiposOperacoes = TipoOperacao::orderBy('created_at', 'asc')->get();

        return Inertia::render('Admin/Operacoes/Index', [
            'operacoes' => $operacoes,
            'ativos' => $ativos,
            'corretoras' => $corretoras,
            'tiposOperacoes' => $tiposOperacoes
        ]);
    }
}
