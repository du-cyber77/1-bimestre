@extends('layouts.app')

@section('title', 'Turmas - CIEP 1402')

@section('content')

    {{-- O @if(session('success')) não é mais tão necessário, pois usaremos toasts, mas pode manter. --}}

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 display-5">Gerenciamento de Turmas</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="turmas-table">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome da Turma</th>
                            <th class="text-center">Nº de Alunos</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($turmas as $turma)
                            <tr id="turma-row-{{ $turma->id }}">
                                <td>{{ $turma->id }}</td>
                                <td>
                                    <a href="{{ route('turmas.show', $turma) }}" class="fw-bold">{{ $turma->nome }}</a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill">{{ $turma->alunos_count }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('turmas.modal.edit', $turma) }}" 
                                       class="btn btn-warning btn-sm" 
                                       title="Editar"
                                       data-bs-toggle="modal" 
                                       data-bs-target="#formModal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-danger btn-sm btn-delete" 
                                            title="Excluir"
                                            data-url-delete="{{ route('turmas.destroy', $turma) }}"
                                            data-entity-name="turma">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Nenhuma turma cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection