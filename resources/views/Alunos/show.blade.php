@extends('layouts.app')

@section('title', 'Detalhes do Aluno')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate me-2"></i>
                        {{ $aluno->nome_aluno }}
                    </h5>
                    <span class="badge bg-primary rounded-pill fs-6">
                        {{ $aluno->turma->nome ?? 'Sem Turma' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $aluno->id }}</p>
                            <p><strong>Nome do Responsável:</strong> {{ $aluno->nome_responsavel }}</p>
                            <p><strong>Data de Nascimento:</strong> {{ $aluno->data_nascimento->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Caixa:</strong> {{ $aluno->numero_caixa ?? 'N/A' }}</p>
                            <p><strong>Pasta:</strong> {{ $aluno->numero_pasta ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Observações:</strong></p>
                    <p>{{ $aluno->obs ?? 'Nenhuma observação.' }}</p>
                </div>
                <div class="card-footer text-end">
                    
                    <a href="{{ route('alunos.modal.edit', $aluno) }}" 
                       class="btn btn-warning"
                       data-bs-toggle="modal" 
                       data-bs-target="#formModal">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection