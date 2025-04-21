<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClasseAtivo extends Model
{
    use HasUuids;
    use HasFactory;

    protected $table = 'classes_ativos';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'nome',
        'descricao',
        'nome_interno',
    ];

    public function ativos()
    {
        return $this->hasMany(Ativo::class, 'classe_ativo_uid', 'uid');
    }
}
