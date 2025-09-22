@extends('layouts.app')

@section('title', 'Detalhes da Turma: ' . $turma->nome)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="fas fa-arrow-left me-2"></i>Voltar para todas as turmas
        </a>
        <h1 class="mb-0 display-5">{{ $turma->nome }}</h1>
    </div>
    
    {{-- O BOTÃO PARA ADICIONAR ALUNOS --}}
    <button id="add-aluno-btn" class="btn btn-success btn-lg" data-turma-id="{{ $turma->id }}">
        <i class="fas fa-user-plus me-2"></i>Adicionar Aluno à Turma
    </button>
</div>


<div class="card shadow-sm">
    <div class="card-header">
        <h5>Alunos nesta turma ({{ $turma->alunos->count() }})</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome do Aluno</th>
                        <th>Responsável</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($turma->alunos as $aluno)
                        <tr>
                            <td>{{ $aluno->id }}</td>
                            <td>{{ $aluno->nome_aluno }}</td>
                            <td>{{ $aluno->nome_responsavel }}</td>
                            <td class="text-center">
                                <a href="{{ route('alunos.show', $aluno) }}" class="btn btn-info btn-sm" title="Ver Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('alunos.edit', $aluno) }}" class="btn btn-warning btn-sm" title="Editar Aluno">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Ainda não há alunos nesta turma.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- A modal de formulário do Aluno que já existe no seu layout principal será reutilizada aqui. --}}
{{-- Não precisamos duplicar o HTML dela. --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addAlunoBtn = document.getElementById('add-aluno-btn');
    if (addAlunoBtn) {
        addAlunoBtn.addEventListener('click', function() {
            const turmaId = this.dataset.turmaId;
            
            // Reutiliza a função global que criamos para abrir a modal de formulário
            // Esta função deve existir no seu script principal (ex: index.blade.php dos alunos ou app.blade.php)
            if (typeof openFormModal === 'function') {
                const createUrl = '{{ route("alunos.create") }}';
                openFormModal(createUrl, 'Cadastrar Novo Aluno');

                // Aqui está o truque: esperamos o formulário carregar e então pré-selecionamos a turma
                const modalElement = document.getElementById('formModal');
                modalElement.addEventListener('shown.bs.modal', function handler() {
                    const turmaSelect = modalElement.querySelector('#turma_id');
                    if (turmaSelect) {
                        turmaSelect.value = turmaId;
                    }
                    // Remove o listener para não ser executado múltiplas vezes
                    modalElement.removeEventListener('shown.bs.modal', handler);
                });

            } else {
                console.error('A função openFormModal não foi encontrada. Certifique-se de que ela está disponível globalmente.');
            }
        });
    }
});
</script>
@endpush