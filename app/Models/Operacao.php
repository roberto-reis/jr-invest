<?php

namespace App\Models;

use App\Models\Corretora;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operacao extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'operacoes';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'user_id',
        'ativo_uid',
        'tipo_operacao_uid',
        'corretora_uid',
        'cotacao_preco',
        'quantidade',
        'data_operacao',
    ];

    protected $appends = [
        'valor_total',
    ];

    protected $casts = [
        'data_operacao' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }

    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'ativo_uid', 'uid');
    }

    public function tipoOperacao()
    {
        return $this->belongsTo(TipoOperacao::class, 'tipo_operacao_uid', 'uid');
    }

    public function corretora()
    {
        return $this->belongsTo(Corretora::class, 'corretora_uid');
    }

    public function getValorTotalAttribute()
    {
        return $this->cotacao_preco * $this->attributes['quantidade'];
    }

    public function scopeJoinAtivo($query)
    {
        return $query->join('ativos', 'operacoes.ativo_uid', '=', 'ativos.uid');
    }

    public function scopeJoinTipoOperacao($query)
    {
        return $query->join('tipos_operacoes', 'operacoes.tipo_operacao_uid', '=', 'tipos_operacoes.uid');
    }

    public function scopeJoinCorretora($query)
    {
        return $query->join('corretoras', 'operacoes.corretora_uid', '=', 'corretoras.uid');
    }

    public function scopeJoinClasseAtivo($query)
    {
        return $query->join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid');
    }

}
