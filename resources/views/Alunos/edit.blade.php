<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Aluno</h1>
        <hr>

        <form action="{{ route('alunos.update', $aluno->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="mb-3">
                <label for="nome_aluno" class="form-label">Nome do Aluno:</label>
                <input type="text" class="form-control" id="nome_aluno" name="nome_aluno" value="{{ $aluno->nome_aluno }}" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="numero_caixa" class="form-label">Número da Caixa:</label>
                    <input type="text" class="form-control" id="numero_caixa" name="numero_caixa" value="{{ $aluno->numero_caixa }}" required>
                </div>
                <div class="col">
                    <label for="numero_pasta" class="form-label">Número da Pasta:</label>
                    <input type="text" class="form-control" id="numero_pasta" name="numero_pasta" value="{{ $aluno->numero_pasta }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="nome_responsavel" class="form-label">Responsável:</label>
                <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" value="{{ $aluno->nome_responsavel }}" required>
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $aluno->data_nascimento }}" required>
            </div>
            <div class="mb-3">
                <label for="obs" class="form-label">Observações:</label>
                <textarea class="form-control" id="obs" name="obs" rows="3">{{ $aluno->obs }}</textarea>
            </div>

            <a href="/" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
</body>
</html>