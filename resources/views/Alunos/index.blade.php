<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema CIEP 1402 - Alunos Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

        <div class="container mt-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Alunos Cadastrado no CIEP 142</h1>
            <a href="/alunos/create" class="btn btn-primary">+ Novo Aluno</a>
        </div>
        <hr>

        <form method="GET" action="{{ url('/') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nome, caixa ou pasta..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome do Aluno</th>
                    <th>Caixa</th>
                    <th>Pasta</th>
                    <th>Responsável</th>
                    <th>Data de Nascimento</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alunos as $aluno)
                    <tr>
                        <td>{{ $aluno->id }}</td>
                        <td>{{ $aluno->nome_aluno }}</td>
                        <td>{{ $aluno->numero_caixa }}</td>
                        <td>{{ $aluno->numero_pasta }}</td>
                        <td>{{ $aluno->nome_responsavel }}</td>
                        <td>{{ \Carbon\Carbon::parse($aluno->data_nascimento)->format('d/m/Y') }}</td>
                        <td>{{ $aluno->obs }}</td>
                        <td>
                            <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</button>
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
    </div>
</body>
</html>