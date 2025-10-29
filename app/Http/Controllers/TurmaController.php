<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request; // Importar Request
use App\Http\Requests\StoreTurmaRequest;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::withCount('alunos')->orderBy('nome')->get();
        return view('turmas.index', compact('turmas'));
    }

    /**
     * NOVO: Carrega o formulário de criação para a modal.
     */
    public function createModal()
    {
        $turma = new Turma();
        return view('turmas._form', compact('turma'));
    }

    /**
     * ATUALIZADO: Salva e retorna JSON.
     */
    public function store(StoreTurmaRequest $request)
    {
        $turma = Turma::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Turma criada com sucesso!',
            'turma' => $turma
        ]);
    }

    public function show(Turma $turma)
    {
        $turma->load('alunos');
        return view('turmas.show', compact('turma'));
    }

    /**
     * NOVO: Carrega o formulário de edição para a modal.
     */
    public function editModal(Turma $turma)
    {
        return view('turmas._form', compact('turma'));
    }

    /**
     * ATUALIZADO: Atualiza e retorna JSON.
     */
    public function update(StoreTurmaRequest $request, Turma $turma)
    {
        $turma->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Turma atualizada com sucesso!',
            'turma' => $turma
        ]);
    }

    /**
     * ATUALIZADO: Exclui e retorna JSON.
     */
    public function destroy(Turma $turma)
    {
        if ($turma->alunos()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir esta turma, pois ela possui alunos.'
            ], 422); // Erro de validação
        }

        $turma->delete();

        return response()->json([
            'success' => true,
            'message' => 'Turma excluída com sucesso!'
        ]);
    }

    // Métodos create() e edit() não são mais necessários
}