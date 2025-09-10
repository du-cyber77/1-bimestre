@extends('layouts.app')

@section('title', 'Alunos Cadastrados')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="mb-3">Alunos Cadastrados</h1>

    {{-- INÍCIO DO NOVO FORMULÁRIO DE BUSCA AVANÇADA --}}
    <form method="GET" action="{{ url('/') }}" class="mb-4 p-3 border rounded">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="filtro_nome" class="form-label">Nome do Aluno</label>
                <input type="text" name="filtro_nome" id="filtro_nome" class="form-control" value="{{ request('filtro_nome') }}">
            </div>
            <div class="col-md-4">
                <label for="filtro_responsavel" class="form-label">Nome do Responsável</label>
                <input type="text" name="filtro_responsavel" id="filtro_responsavel" class="form-control" value="{{ request('filtro_responsavel') }}">
            </div>
            <div class="col-md-3">
                <label for="filtro_turma_id" class="form-label">Turma</label>
                <select name="filtro_turma_id" id="filtro_turma_id" class="form-control">
                    <option value="">Todas</option>
                    @foreach($turmas as $turma)
                        <option value="{{ $turma->id }}" {{ request('filtro_turma_id') == $turma->id ? 'selected' : '' }}>
                            {{ $turma->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </form>
    {{-- FIM DO NOVO FORMULÁRIO DE BUSCA AVANÇADA --}}


    <table class="table table-bordered table-striped">
        {{-- INÍCIO DO CABEÇALHO ATUALIZADO --}}
        <thead class="table-light">
            <tr>
                <th>
                    @php
                        $idDirection = ($sort == 'id' && $direction == 'asc') ? 'desc' : 'asc';
                        $idQuery = array_merge(request()->query(), ['sort' => 'id', 'direction' => $idDirection]);
                    @endphp
                    <a href="{{ url('/') }}?{{ http_build_query($idQuery) }}">
                        ID @if($sort == 'id')<span>{{ $direction == 'asc' ? '▲' : '▼' }}</span>@endif
                    </a>
                </th>
                <th>
                    @php
                        $nomeDirection = ($sort == 'nome_aluno' && $direction == 'asc') ? 'desc' : 'asc';
                        $nomeQuery = array_merge(request()->query(), ['sort' => 'nome_aluno', 'direction' => $nomeDirection]);
                    @endphp
                    <a href="{{ url('/') }}?{{ http_build_query($nomeQuery) }}">
                        Nome do Aluno @if($sort == 'nome_aluno')<span>{{ $direction == 'asc' ? '▲' : '▼' }}</span>@endif
                    </a>
                </th>
                <th>Caixa</th>
                <th>Pasta</th>
                <th>Responsável</th>
                <th>Turma</th>
                <th>
                    @php
                        $dataDirection = ($sort == 'data_nascimento' && $direction == 'asc') ? 'desc' : 'asc';
                        $dataQuery = array_merge(request()->query(), ['sort' => 'data_nascimento', 'direction' => $dataDirection]);
                    @endphp
                    <a href="{{ url('/') }}?{{ http_build_query($dataQuery) }}">
                        Data de Nascimento @if($sort == 'data_nascimento')<span>{{ $direction == 'asc' ? '▲' : '▼' }}</span>@endif
                    </a>
                </th>
                <th>Ações</th>
            </tr>
        </thead>
        {{-- FIM DO CABEÇALHO ATUALIZADO --}}

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
                    <td>{{ $aluno->turma->nome ?? 'Sem Turma' }}</td>
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
                    <td colspan="8" class="text-center">Nenhum aluno encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $alunos->links() }}
    </div>

@endsection