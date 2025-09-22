{{-- resources/views/turmas/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Nova Turma')
@section('content')
    <h1>Nova Turma</h1>
    <hr>
    <form action="{{ route('turmas.store') }}" method="POST" novalidate>
        @include('turmas._form')
        <a href="{{ route('turmas.index') }}" class="btn btn-secondary">
    <i class="fas fa-times me-2"></i>Cancelar
</a>
<button type="submit" class="btn btn-primary">
    <i class="fas fa-save me-2"></i>Salvar
</button>
    </form>
@endsection