<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RebalanceamentoClasse extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'rebalanceamento_classes';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'user_id',
        'classe_ativo_uid',
        'percentual',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'uid', 'user_uid');
    }

    public function classeAtivo()
    {
        return $this->hasOne(ClasseAtivo::class,  'uid', 'classe_ativo_uid');
    }

    public function scopeJoinClasseAtivo($query)
    {
        return $query->join('classes_ativos', 'rebalanceamento_classes.classe_ativo_uid', '=', 'classes_ativos.uid');
    }
}
