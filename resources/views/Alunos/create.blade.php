@extends('layouts.app')

@section('title', 'Novo Aluno')

@section('content')
    <h1>Novo Aluno</h1>
    <hr>

    <form action="{{ route('alunos.store') }}" method="POST" novalidate>
        @csrf
        {{-- Incluímos o restante do formulário aqui --}}
        @include('alunos._form')

        <a href="/" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@endsection