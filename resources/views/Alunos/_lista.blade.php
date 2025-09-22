@forelse ($alunos as $aluno)
    <tr>
        <td>{{ $aluno->id }}</td>
        <td>
            <a href="{{ route('alunos.show', $aluno->id) }}">{{ $aluno->nome_aluno }}</a>
        </td>
        <td>{{ $aluno->nome_responsavel }}</td>
        <td>
            <span class="badge bg-secondary">{{ $aluno->turma->nome ?? 'Sem Turma' }}</span>
        </td>
        <td>{{ $aluno->data_nascimento->format('d/m/Y') }}</td>
        <td class="text-center">
            <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-warning btn-sm" title="Editar">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
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
        <td colspan="6" class="text-center py-4">
            Nenhum aluno encontrado.
        </td>
    </tr>
@endforelse