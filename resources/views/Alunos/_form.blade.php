<form action="{{ $aluno->exists ? route('alunos.update', $aluno) : route('alunos.store') }}" method="POST" id="alunoForm" novalidate>
    @csrf
    @if ($aluno->exists)
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nome_aluno" class="form-label">Nome do Aluno:</label>
            <input type="text" class="form-control" id="nome_aluno" name="nome_aluno" value="{{ old('nome_aluno', $aluno->nome_aluno) }}">
            <div class="invalid-feedback" data-field="nome_aluno"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="nome_responsavel" class="form-label">Nome do Responsável:</label>
            <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" value="{{ old('nome_responsavel', $aluno->nome_responsavel) }}">
            <div class="invalid-feedback" data-field="nome_responsavel"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', optional($aluno->data_nascimento)->format('Y-m-d')) }}">
            <div class="invalid-feedback" data-field="data_nascimento"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="turma_id" class="form-label">Turma:</label>
            <select class="form-select" id="turma_id" name="turma_id">
                <option value="">Sem Turma</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ old('turma_id', $aluno->turma_id) == $turma->id ? 'selected' : '' }}>
                        {{ $turma->nome }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback" data-field="turma_id"></div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-6 mb-3">
            <label for="numero_caixa" class="form-label">Número da Caixa:</label>
            <input type="text" class="form-control" id="numero_caixa" name="numero_caixa" value="{{ old('numero_caixa', $aluno->numero_caixa) }}">
            <div class="invalid-feedback" data-field="numero_caixa"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="numero_pasta" class="form-label">Número da Pasta:</label>
            <input type="text" class="form-control" id="numero_pasta" name="numero_pasta" value="{{ old('numero_pasta', $aluno->numero_pasta) }}">
            <div class="invalid-feedback" data-field="numero_pasta"></div>
        </div>
    </div>
    <div class="mb-3">
        <label for="obs" class="form-label">Observações:</label>
        <textarea class="form-control" id="obs" name="obs" rows="3">{{ old('obs', $aluno->obs) }}</textarea>
        <div class="invalid-feedback" data-field="obs"></div>
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