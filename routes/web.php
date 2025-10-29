<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota principal que carrega o painel e a lista (agora com filtro)
Route::get('/', [AlunoController::class, 'index'])->name('home');

// Rotas de resource para Alunos (apenas as ações de backend)
Route::resource('alunos', AlunoController::class)->only([
    'store', 'update', 'destroy', 'show'
]);

// Rotas de resource para Turmas (ações de backend e a listagem)
Route::resource('turmas', TurmaController::class)->except([
    'create', 'edit' // Vamos usar as rotas de modal
]);

// --- NOVAS ROTAS PARA CARREGAR MODAIS ---

// Rotas para Modais de Alunos
Route::get('/modal/alunos/create', [AlunoController::class, 'createModal'])
     ->name('alunos.modal.create');
Route::get('/modal/alunos/{aluno}/edit', [AlunoController::class, 'editModal'])
     ->name('alunos.modal.edit');

// Rotas para Modais de Turmas
Route::get('/modal/turmas/create', [TurmaController::class, 'createModal'])
     ->name('turmas.modal.create');
Route::get('/modal/turmas/{turma}/edit', [TurmaController::class, 'editModal'])
     ->name('turmas.modal.edit');


// Rota de Relatórios
Route::get('/relatorios', [ReportController::class, 'index'])->name('reports.index');