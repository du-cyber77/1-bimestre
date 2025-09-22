<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Http\Requests\StoreTurmaRequest;

class TurmaController extends Controller
{
    public function index()
    {
        // Usamos withCount para pegar o número de alunos de forma eficiente
        $turmas = Turma::withCount('alunos')->orderBy('nome')->get();
        return view('turmas.index', compact('turmas'));
    }

    public function create()
    {
        return view('turmas.create');
    }

    public function store(StoreTurmaRequest $request)
    {
        Turma::create($request->validated());
        return redirect()->route('turmas.index')->with('success', 'Turma cadastrada com sucesso!');
    }

    /**
     * NOVO/ATUALIZADO: Método para exibir os detalhes da turma.
     */
    public function show(Turma $turma)
    {
        // Carrega a turma com a lista de seus alunos
        $turma->load('alunos');
        return view('turmas.show', compact('turma'));
    }

    public function edit(Turma $turma)
    {
        return view('turmas.edit', compact('turma'));
    }

    public function update(StoreTurmaRequest $request, Turma $turma)
    {
        $turma->update($request->validated());
        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }

    public function destroy(Turma $turma)
    {
        // Se você implementou o Observer, a lógica de verificação já está lá.
        // Se não, adicione a verificação aqui.
        if ($turma->alunos()->count() > 0) {
            return back()->withErrors(['error' => 'Não é possível excluir uma turma que possui alunos.']);
        }
        $turma->delete();
        return redirect()->route('turmas.index')->with('success', 'Turma excluída com sucesso!');
    }
}