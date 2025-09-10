<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_aluno',
        'nome_responsavel',
        'numero_caixa',
        'numero_pasta',
        'data_nascimento',
        'obs',
        'turma_id', 
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}