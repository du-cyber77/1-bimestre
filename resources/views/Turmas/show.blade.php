@extends('layouts.app')

@section('title', 'Detalhes da Turma: ' . $turma->nome)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="fas fa-arrow-left me-2"></i>Voltar para todas as turmas
        </a>
        <h1 class="mb-0 display-5">{{ $turma->nome }}</h1>
    </div>
    
    {{-- Este é o botão que vamos fazer funcionar --}}
    <button id="add-aluno-btn" class="btn btn-success btn-lg" data-turma-id="{{ $turma->id }}">
        <i class="fas fa-user-plus me-2"></i>Adicionar Aluno à Turma
    </button>
</div>


<div class="card shadow-sm">
    <div class="card-header">
        <h5>Alunos nesta turma ({{ $turma->alunos->count() }})</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome do Aluno</th>
                        <th>Responsável</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($turma->alunos as $aluno)
                        <tr>
                            <td>{{ $aluno->id }}</td>
                            <td>{{ $aluno->nome_aluno }}</td>
                            <td>{{ $aluno->nome_responsavel }}</td>
                            <td class="text-center">
                                <a href="{{ route('alunos.show', $aluno) }}" class="btn btn-info btn-sm" title="Ver Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('alunos.edit', $aluno) }}" class="btn btn-warning btn-sm" title="Editar Aluno">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Ainda não há alunos nesta turma.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- O @push('scripts') foi removido daqui, pois a lógica agora é global --}}
@endsection