@php
    $isEdit = $turma->exists;
    $actionUrl = $isEdit ? route('turmas.update', $turma) : route('turmas.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $title = $isEdit ? 'Editar Turma' : 'Cadastrar Nova Turma';
@endphp

<form action="{{ $actionUrl }}" 
      method="POST" 
      id="turmaForm" 
      novalidate
      data-action="{{ $actionUrl }}"
      data-method="{{ $method }}"
      data-title="{{ $title }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Turma:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $turma->nome) }}" required>
        <div class="invalid-feedback" data-field="nome"></div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Salvar
        </button>
    </div>
</form>