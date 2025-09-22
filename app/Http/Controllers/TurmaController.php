<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;
// 1. IMPORTAMOS O NOSSO NOVO REQUEST
use App\Http\Requests\StoreTurmaRequest;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Esta parte já estava correta, com a contagem de alunos
        $query = Turma::withCount('alunos');

        if ($request->filled('filtro_nome')) {
            $query->where('nome', 'like', '%' . $request->input('filtro_nome') . '%');
        }

        $turmas = $query->paginate(10)->withQueryString();

        return view('turmas.index', compact('turmas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('turmas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // 2. SUBSTITUÍMOS 'Request' por 'StoreTurmaRequest'
    public function store(StoreTurmaRequest $request)
    {
        // A validação agora acontece AUTOMATICAMENTE!
        // Adeus, bloco $request->validate()!

        // Usamos $request->validated() para pegar apenas os dados que foram validados, o que é mais seguro.
        Turma::create($request->validated());

        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma)
    {
        return view('turmas.edit', compact('turma'));
    }

    /**
     * Update the specified resource in storage.
     */
    // 3. FAZEMOS A MESMA SUBSTITUIÇÃO AQUI
    public function update(StoreTurmaRequest $request, Turma $turma)
    {
        // A validação também já foi feita aqui!
        $turma->update($request->validated());

        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        // Esta lógica de segurança já estava correta.
        if ($turma->alunos()->count() > 0) {
            return redirect()->route('turmas.index')
                             ->with('error', 'Esta turma não pode ser excluída, pois possui alunos vinculados.');
        }

        $turma->delete();
        
        return redirect()->route('turmas.index')->with('success', 'Turma excluída com sucesso!');
    }
}

