<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    // Listar todas as turmas
    public function index()
    {
        $turmas = Turma::paginate(10);
        return view('turmas.index', compact('turmas'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        return view('turmas.create');
    }

    // Salvar nova turma no banco
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:turmas,nome',
        ]);

        Turma::create($request->all());

        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso!');
    }

    // Mostrar formulário de edição
    public function edit(Turma $turma)
    {
        return view('turmas.edit', compact('turma'));
    }

    // Atualizar turma no banco
    public function update(Request $request, Turma $turma)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:turmas,nome,' . $turma->id,
        ]);

        $turma->update($request->all());

        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }

    // Excluir turma do banco
    public function destroy(Turma $turma)
    {
        $turma->delete();
        // Lembre-se: os alunos desta turma não serão deletados,
        // apenas o campo 'turma_id' deles ficará nulo, como definimos na migration.
        return redirect()->route('turmas.index')->with('success', 'Turma excluída com sucesso!');
    }
}