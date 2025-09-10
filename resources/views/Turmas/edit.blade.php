{{-- resources/views/turmas/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Editar Turma')
@section('content')
    <h1>Editar Turma</h1>
    <hr>
    <form action="{{ route('turmas.update', $turma->id) }}" method="POST" novalidate>
        @method('PUT')
        @include('turmas._form')
        <a href="{{ route('turmas.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection