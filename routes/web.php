<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController; // <-- Verifique se esta linha existe!

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

// Rota para a página inicial (http://127.0.0.1:8000)
Route::get('/', [AlunoController::class, 'index']); // <-- Verifique esta linha!

// Rota do tipo resource para gerenciar os alunos (/alunos, /alunos/create, etc.)
Route::resource('alunos', AlunoController::class);