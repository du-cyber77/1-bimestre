@extends('layouts.app')

@section('title', 'CIEP 1402')

@section('content')

    {{-- Este @if(session('success')) não será mais usado, pois usamos Toasts --}}
    {{-- <div class="alert alert-success alert-dismissible fade show" role="alert">...</div> --}}

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 display-5">Painel de Controle</h1>
    </div>

    <div class="row mb-4">
        <x-stat-card 
            :value="$totalAlunos"
            label="Alunos Cadastrados"
            icon="fa-user-graduate"
            bgColor="bg-primary" />

        <x-stat-card 
            :value="$totalTurmas"
            label="Turmas Ativas"
            icon="fa-chalkboard-user"
            bgColor="bg-success" />

        @if($turmaMaisAlunos && $turmaMaisAlunos->alunos_count > 0)
            <x-stat-card 
                :value="$turmaMaisAlunos->nome"
                label="Turma Destaque ({{ $turmaMaisAlunos->alunos_count }} alunos)"
                icon="fa-star"
                bgColor="bg-info"
                class="col-lg-4 col-md-12 mb-3" /> {{-- Podemos sobrescrever a coluna --}}
        @else
            <x-stat-card 
                value="-"
                label="Nenhuma turma com alunos"
                icon="fa-star"
                bgColor="bg-info"
                class="col-lg-4 col-md-12 mb-3" />
        @endif
    </div>

    <h3 class="mt-5 border-bottom pb-2 mb-3">Listagem Dinâmica de Alunos</h3>

    <form id="filter-form" 
          class="mb-4 p-3 border rounded bg-light" 
          onsubmit="return false;"
          data-filter-url="{{ route('home') }}">
        
        <span class="spinner-border spinner-border-sm text-primary" id="filter-spinner" role="status"></span>
        
        <div class="row g-3 align-items-end">
            <div class="col-md-4"><label for="filtro_nome" class="form-label">Nome do Aluno</label><input type="text" name="filtro_nome" id="filtro_nome" class="form-control" placeholder="Comece a digitar..."></div>
            <div class="col-md-4"><label for="filtro_responsavel" class="form-label">Nome do Responsável</label><input type="text" name="filtro_responsavel" id="filtro_responsavel" class="form-control" placeholder="Comece a digitar..."></div>
            <div class="col-md-4"><label for="filtro_turma_id" class="form-label">Turma</label><select name="filtro_turma_id" id="filtro_turma_id" class="form-select"><option value="">Todas as Turmas</option>@foreach($turmas as $turma)<option value="{{ $turma->id }}">{{ $turma->nome }}</option>@endforeach</select></div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr><th>ID</th><th>Nome do Aluno</th><th>Responsável</th><th>Turma</th><th>Data de Nascimento</th><th class="text-center">Ações</th></tr>
            </thead>
            <tbody id="alunos-table-body">
                @include('alunos._lista', ['alunos' => $alunos])
            </tbody>
        </table>
    </div>
    
    <div class="mt-4" id="pagination-container">
        {{ $alunos->links() }}
    </div>

@endsection