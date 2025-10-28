{{-- resources/views/turmas/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Nova Turma')
@section('content')
    <h1>Nova Turma</h1>
    <hr>
    {{-- Apenas incluímos o formulário parcial --}}
    <form action="{{ route('turmas.store') }}" method="POST" novalidate>
        @include('turmas._form')
    </form>
@endsection