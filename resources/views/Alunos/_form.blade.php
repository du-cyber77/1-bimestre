{{-- resources/views/alunos/_form.blade.php --}}

<div class="mb-3">
    <label for="nome_aluno" class="form-label">Nome do Aluno:</label>
    <input type="text" class="form-control @error('nome_aluno') is-invalid @enderror" id="nome_aluno" name="nome_aluno" value="{{ $aluno->nome_aluno ?? old('nome_aluno') }}" required>
    @error('nome_aluno')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="row mb-3">
    <div class="col">
        <label for="numero_caixa" class="form-label">Número da Caixa:</label>
        <input type="text" class="form-control @error('numero_caixa') is-invalid @enderror" id="numero_caixa" name="numero_caixa" value="{{ $aluno->numero_caixa ?? old('numero_caixa') }}" required>
        @error('numero_caixa')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col">
        <label for="numero_pasta" class="form-label">Número da Pasta:</label>
        <input type="text" class="form-control @error('numero_pasta') is-invalid @enderror" id="numero_pasta" name="numero_pasta" value="{{ $aluno->numero_pasta ?? old('numero_pasta') }}" required>
        @error('numero_pasta')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="nome_responsavel" class="form-label">Responsável:</label>
    <input type="text" class="form-control @error('nome_responsavel') is-invalid @enderror" id="nome_responsavel" name="nome_responsavel" value="{{ $aluno->nome_responsavel ?? old('nome_responsavel') }}" required>
    @error('nome_responsavel')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="turma_id" class="form-label">Turma:</label>
    <select class="form-control @error('turma_id') is-invalid @enderror" id="turma_id" name="turma_id">
        <option value="">Selecione uma Turma</option>
        @foreach($turmas as $turma)
            <option value="{{ $turma->id }}" {{ ($aluno->turma_id ?? old('turma_id')) == $turma->id ? 'selected' : '' }}>
                {{ $turma->nome }}
            </option>
        @endforeach
    </select>
    @error('turma_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>



<div class="mb-3">
    <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento" name="data_nascimento" value="{{ $aluno->data_nascimento ?? old('data_nascimento') }}" required>
    @error('data_nascimento')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="obs" class="form-label">Observações:</label>
    <textarea class="form-control" id="obs" name="obs" rows="3">{{ $aluno->obs ?? old('obs') }}</textarea>
</div>