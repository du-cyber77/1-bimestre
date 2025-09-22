<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rota principal que carrega a view do painel
Route::get('/', [AlunoController::class, 'index'])->name('home');

// NOVA ROTA: Endpoint para a busca em tempo real (AJAX)
Route::get('/alunos/search', [AlunoController::class, 'search'])->name('alunos.search');

// Rotas de resource para Alunos (exceto o index, que já definimos como 'home')
Route::resource('alunos', AlunoController::class)->except(['index']);

// Rotas de resource para Turmas
Route::resource('turmas', TurmaController::class);

Route::get('/relatorios', [ReportController::class, 'index'])->name('reports.index');