@extends('layouts.app')

@section('title', 'Gerenciar Turmas')

@section('content')
    <div class="container mt-4">
        {{-- Exibição de mensagens de sucesso ou erro --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gerenciar Turmas</h1>
            {{-- Botão para criar uma nova turma --}}
            
        </div>

        {{-- Formulário de filtro e busca --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('turmas.index') }}" class="d-flex">
                    <input type="text" name="filtro_nome" class="form-control me-2" placeholder="Buscar por nome da turma..." value="{{ request('filtro_nome') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabela de turmas --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Nº de Alunos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($turmas as $turma)
                        <tr>
                            <td>{{ $turma->id }}</td>
                            <td>{{ $turma->nome }}</td>
                            {{-- Exibe a contagem de alunos (requer a alteração no Controller) --}}
                            <td><span class="badge bg-secondary">{{ $turma->alunos_count ?? 0 }}</span></td>
                            <td>
                                <a href="{{ route('turmas.edit', $turma->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta turma? Esta ação não pode ser desfeita.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Colspan atualizado para 4 colunas --}}
                            <td colspan="4" class="text-center">Nenhuma turma encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Links de paginação --}}
        <div class="d-flex justify-content-center">
            {{ $turmas->links() }}
        </div>
    </div>

    {{-- Dica: Para os ícones (lixeira, lápis, etc.) funcionarem, adicione o Font Awesome no seu layout principal (app.blade.php) --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" /> --}}
@endsection
