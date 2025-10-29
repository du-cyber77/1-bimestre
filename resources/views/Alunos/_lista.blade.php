@forelse ($alunos as $aluno)
    <tr>
        <td>{{ $aluno->id }}</td>
        <td>
            <a href="{{ route('alunos.show', $aluno->id) }}">{{ $aluno->nome_aluno }}</a>
        </td>
        <td>{{ $aluno->nome_responsavel }}</td>
        <td>
            @if($aluno->turma)
                <span class="badge bg-secondary">{{ $aluno->turma->nome }}</span>
            @else
                <span class="badge bg-light text-dark">Sem Turma</span>
            @endif
        </td>
        <td>{{ $aluno->data_nascimento->format('d/m/Y') }}</td>
        <td class="text-center">
            
            <a href="{{ route('alunos.modal.edit', $aluno->id) }}" 
               class="btn btn-warning btn-sm" 
               title="Editar"
               data-bs-toggle="modal" 
               data-bs-target="#formModal">
                <i class="fas fa-edit"></i>
            </a>
            
            <button type="button" 
                    class="btn btn-danger btn-sm btn-delete" 
                    title="Excluir"
                    data-url-delete="{{ route('alunos.destroy', $aluno->id) }}"
                    data-entity-name="aluno">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-4">
            Nenhum aluno encontrado.
        </td>
    </tr>
@endforelse