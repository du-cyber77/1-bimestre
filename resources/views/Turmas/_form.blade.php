{{-- resources/views/turmas/_form.blade.php --}}
@csrf
<div class="mb-3">
    <label for="nome" class="form-label">Nome da Turma:</label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ $turma->nome ?? old('nome') }}" required>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>