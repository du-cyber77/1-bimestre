@extends('layouts.app')

@section('title', 'Gerenciamento de Turmas')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 display-5">Gerenciamento de Turmas</h1>
        
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome da Turma</th>
                            <th class="text-center">Nº de Alunos</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($turmas as $turma)
                            <tr>
                                <td>{{ $turma->id }}</td>
                                <td>
                                    {{-- Link para a nova página de detalhes --}}
                                    <a href="{{ route('turmas.show', $turma) }}" class="fw-bold">{{ $turma->nome }}</a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill">{{ $turma->alunos_count }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('turmas.edit', $turma) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('turmas.destroy', $turma) }}" method="POST" class="d-inline" onsubmit="return confirm('Atenção! Excluir uma turma não exclui os alunos, mas eles ficarão sem turma. Deseja continuar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Nenhuma turma cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection