@extends('layouts.app')

@section('title', 'Editar Aluno')

@section('content')
    <h1>Editar Aluno</h1>
    <hr>

    <form action="{{ route('alunos.update', $aluno->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        
        @include('alunos._form')

        <a href="/" class="btn btn-secondary">
    <i class="fas fa-times me-2"></i>Cancelar
</a>
<button type="submit" class="btn btn-primary">
    <i class="fas fa-save me-2"></i>Atualizar
</button>
    </form>
@endsection