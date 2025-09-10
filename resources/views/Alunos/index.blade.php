@extends('layouts.app')

@section('title', 'Sistema do CIEP 1402 - Alunos')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Relatório de Alunos Cdastrados no CIEP - 1402</h1>
        <a href="{{ route('alunos.create') }}" class="btn btn-primary">+ Novo Aluno</a>
    </div>

    <form method="GET" action="{{ url('/') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nome, caixa ou pasta..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>
                    @php $idDirection = ($sort == 'id' && $direction == 'asc') ? 'desc' : 'asc'; @endphp
                    <a href="{{ url('/') }}?sort=id&direction={{ $idDirection }}&search={{ request('search') }}">
                        ID @if($sort == 'id')<span>{{ $direction == 'asc' ? '▲' : '▼' }}</span>@endif
                    </a>
                </th>
                <th>
                    @php $nomeDirection = ($sort == 'nome_aluno' && $direction == 'asc') ? 'desc' : 'asc'; @endphp
                    <a href="{{ url('/') }}?sort=nome_aluno&direction={{ $nomeDirection }}&search={{ request('search') }}">
                        Nome do Aluno @if($sort == 'nome_aluno')<span>{{ $direction == 'asc' ? '▲' : '▼' }}</span>@endif
                    </a>
                </th>
                <th>Caixa</th>
                <th>Pasta</th>
                <th>Responsável</th>
                <th>Turma</th> {{-- <-- 1. CABEÇALHO ADICIONADO AQUI --}}
                <th>
                    @php $dataDirection = ($sort == 'data_nascimento' && $direction == 'asc') ? 'desc' : 'asc'; @endphp
                    <a href="{{ url('/') }}?sort=data_nascimento&direction={{ $dataDirection }}&search={{ request('search') }}">
                        Data de Nascimento @if($sort == 'data_nascimento')<span>{{ $direction == 'asc' ? '▲' : '▼' }}</span>@endif
                    </a>
                </th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alunos as $aluno)
                <tr>
                    <td>{{ $aluno->id }}</td>
                    <td>
                        <a href="{{ route('alunos.show', $aluno->id) }}">
                            {{ $aluno->nome_aluno }}
                        </a>
                    </td>
                    <td>{{ $aluno->numero_caixa }}</td>
                    <td>{{ $aluno->numero_pasta }}</td>
                    <td>{{ $aluno->nome_responsavel }}</td>
                    <td>{{ $aluno->turma->nome ?? 'Sem Turma' }}</td> {{-- <-- 2. CÉLULA DA TURMA ADICIONADA AQUI --}}
                    <td>{{ \Carbon\Carbon::parse($aluno->data_nascimento)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?');">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    {{-- ATENÇÃO: Mudei o colspan de 7 para 8 para ajustar à nova coluna --}}
                    <td colspan="8" class="text-center">Nenhum aluno encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $alunos->links() }}
    </div>

@endsection