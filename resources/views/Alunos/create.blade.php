@extends('layouts.app')

@section('title', 'Novo Aluno')

@section('content')
    <h1>Novo Aluno</h1>
    <hr>

    <form action="{{ route('alunos.store') }}" method="POST" novalidate>
        @csrf
        {{-- Incluímos o restante do formulário aqui --}}
        @include('alunos._form')

        <a href="/" class="btn btn-secondary">
    <i class="fas fa-times me-2"></i>Cancelar
</a>
<button type="submit" class="btn btn-primary">
    <i class="fas fa-save me-2"></i>Salvar
</button>
    </form>
@endsection