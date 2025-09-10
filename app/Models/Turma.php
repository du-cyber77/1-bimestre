<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['nome']; // Permite a criação em massa do nome

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
}
