@extends('layouts.app')

@section('title', 'CIEP 1402')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 display-5">Painel de Controle</h1>
    </div>

    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3"><div class="card text-white bg-primary shadow-sm h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><h5 class="card-title display-4">{{ $totalAlunos }}</h5><p class="card-text">Alunos Cadastrados</p></div><i class="fas fa-user-graduate fa-3x opacity-50"></i></div></div></div>
        <div class="col-lg-4 col-md-6 mb-3"><div class="card text-white bg-success shadow-sm h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><h5 class="card-title display-4">{{ $totalTurmas }}</h5><p class="card-text">Turmas Ativas</p></div><i class="fas fa-chalkboard-user fa-3x opacity-50"></i></div></div></div>
        <div class="col-lg-4 col-md-12 mb-3"><div class="card text-white bg-info shadow-sm h-100"><div class="card-body d-flex justify-content-between align-items-center"><div>@if($turmaMaisAlunos && $turmaMaisAlunos->alunos_count > 0)<h5 class="card-title fs-4">{{ $turmaMaisAlunos->nome }}</h5><p class="card-text">Turma Destaque ({{ $turmaMaisAlunos->alunos_count }} alunos)</p>@else<h5 class="card-title fs-4">-</h5><p class="card-text">Nenhuma turma com alunos</p>@endif</div><i class="fas fa-star fa-3x opacity-50"></i></div></div></div>
    </div>

    <h3 class="mt-5 border-bottom pb-2 mb-3">Busca Dinâmica de Alunos</h3>

    <form id="filter-form" class="mb-4 p-3 border rounded bg-light" onsubmit="return false;">
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

    {{-- O HTML da Modal e Toast será movido para o layout principal --}}

@endsection