<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController; // <-- Verifique se esta linha existe!
use App\Http\Controllers\TurmaController;


// Rota para a página inicial (http://127.0.0.1:8000)
Route::get('/', [AlunoController::class, 'index']); 

// Rota do tipo resource para gerenciar os alunos (/alunos, /alunos/create, etc.)
Route::resource('alunos', AlunoController::class);

Route::resource('turmas', TurmaController::class);

