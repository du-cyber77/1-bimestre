@extends('layouts.app')

@section('title', 'Gerenciar Turmas')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1 class="mb-3">Gerenciar Turmas</h1>

    {{-- INÍCIO DO FORMULÁRIO DE FILTRO --}}
    <form method="GET" action="{{ route('turmas.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="filtro_nome" class="form-control" placeholder="Buscar por nome da turma..." value="{{ request('filtro_nome') }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    {{-- FIM DO FORMULÁRIO DE FILTRO --}}


    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($turmas as $turma)
                <tr>
                    <td>{{ $turma->id }}</td>
                    <td>{{ $turma->nome }}</td>
                    <td>
                        <a href="{{ route('turmas.edit', $turma->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza? Excluir a turma não excluirá os alunos, mas eles ficarão sem turma.');">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhuma turma encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="d-flex justify-content-center">
        {{ $turmas->links() }}
    </div>
@endsection