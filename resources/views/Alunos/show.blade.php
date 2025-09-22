@extends('layouts.app')

@section('title', 'Detalhes de ' . $aluno->nome_aluno)

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Detalhes de: {{ $aluno->nome_aluno }}</h1>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $aluno->id }}</p>
            <p><strong>Nome do Responsável:</strong> {{ $aluno->nome_responsavel }}</p>
            <p><strong>Turma:</strong> <span class="badge bg-info text-dark">{{ $aluno->turma->nome ?? 'Sem Turma' }}</span></p>
            <p><strong>Data de Nascimento:</strong> {{ $aluno->data_nascimento->format('d/m/Y') }}</p>
            <hr>
            <p><strong>Número da Caixa:</strong> {{ $aluno->numero_caixa }}</p>
            <p><strong>Número da Pasta:</strong> {{ $aluno->numero_pasta }}</p>
            <hr>
            <p><strong>Observações:</strong></p>
            <p>{{ $aluno->obs ?? 'Nenhuma observação.' }}</p>
            <hr>
            <p><strong>Data de Cadastro:</strong> {{ $aluno->created_at->format('d/m/Y \à\s H:i') }}</p>
            <p><strong>Última Atualização:</strong> {{ $aluno->updated_at->format('d/m/Y \à\s H:i') }}</p>
        </div>
        <div class="card-footer">
    <a href="{{ url('/') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar para a Lista
    </a>
    <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Editar
    </a>
</div>
    </div>
@endsection