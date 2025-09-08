<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Verifique esta linha
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory; // <-- E esta linha

    protected $fillable = [
        'nome_aluno',
        'nome_responsavel',
        'numero_caixa',
        'numero_pasta',
        'data_nascimento',
        'obs',
    ];
}