{{-- resources/views/turmas/_form.blade.php --}}

<form action="{{ $turma->exists ? route('turmas.update', $turma) : route('turmas.store') }}" method="POST" id="turmaForm" novalidate>
    @csrf
    @if ($turma->exists)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Turma:</label>
        
        {{-- 
          1. Removemos a classe @error('nome') daqui, pois o JS vai controlar isso.
        --}}
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $turma->nome) }}" required>
        
        {{-- 
          2. Trocamos o @error por um div padronizado 'invalid-feedback'
             que o nosso JavaScript (em app.blade.php) sabe como usar.
        --}}
        <div class="invalid-feedback" data-field="nome"></div>
    </div>

    {{-- 
      3. Adicionamos os botões de "Cancelar" e "Salvar" que faltavam.
         Isto é essencial para a modal.
    --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Salvar
        </button>
    </div>
</form>