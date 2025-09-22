<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // Importe o Builder

class Aluno extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_aluno',
        'nome_responsavel',
        'numero_caixa',
        'numero_pasta',
        'data_nascimento',
        'obs',
        'turma_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_nascimento' => 'date',
    ];

    /**
     * Define o relacionamento com a Turma.
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    // --- ESCOPOS LOCAIS PARA FILTROS ---

    /**
     * Escopo para filtrar por nome do aluno.
     */
    public function scopeNome(Builder $query, ?string $nome): Builder
    {
        if ($nome) {
            return $query->where('nome_aluno', 'like', '%' . $nome . '%');
        }
        return $query;
    }

    /**
     * Escopo para filtrar por nome do responsável.
     */
    public function scopeResponsavel(Builder $query, ?string $nome): Builder
    {
        if ($nome) {
            return $query->where('nome_responsavel', 'like', '%' . $nome . '%');
        }
        return $query;
    }

    /**
     * Escopo para filtrar por ID da turma.
     */
    public function scopeTurmaId(Builder $query, ?int $turmaId): Builder
    {
        if ($turmaId) {
            return $query->where('turma_id', $turmaId);
        }
        return $query;
    }
}