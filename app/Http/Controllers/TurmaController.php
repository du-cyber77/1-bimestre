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
        $turma = new Turma(); // Cria uma turma vazia

        // ESTA VERIFICAÇÃO É ESSENCIAL:
        if (request()->ajax()) {
            // Se for AJAX (modal), retorna SÓ o formulário
            return view('turmas._form', compact('turma'));
        }

        // Se não for AJAX, retorna a página completa (se existir)
        return view('turmas.create', compact('turma')); //
    }

    public function store(StoreTurmaRequest $request)
    {
        // A lógica de criação está correta
        $turma = Turma::create($request->validated());

        // ***** INÍCIO DA CORREÇÃO *****
        // Se for AJAX (da modal), retorna JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Turma criada com sucesso!',
                'turma' => $turma // Opcional, mas bom ter
            ]);
        }
        // ***** FIM DA CORREÇÃO *****

        // Se for um POST normal (sem AJAX), mantém o redirect
        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso.');
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

    public function edit(Turma $turma) // Laravel encontra a turma pelo ID
    {
        // ESTA VERIFICAÇÃO É ESSENCIAL:
        if (request()->ajax()) {
            // Se for AJAX (modal), retorna SÓ o formulário
            return view('turmas._form', compact('turma')); //
        }

        // Se não for AJAX, retorna a página completa (se existir)
        return view('turmas.edit', compact('turma')); //
    }

    public function update(StoreTurmaRequest $request, Turma $turma)
    {
        // A lógica de update está correta
        $turma->update($request->validated());

        // ***** INÍCIO DA CORREÇÃO *****
        // Se for AJAX (da modal), retorna JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Turma atualizada com sucesso!',
                'turma' => $turma
            ]);
        }
    
    }
    public function destroy(Turma $turma)
    {
        // 1. A sua verificação está correta.
        if ($turma->alunos()->count() > 0) {
            
            // ***** INÍCIO DA CORREÇÃO *****
            // Se for AJAX, retorna um JSON de erro
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir esta turma, pois ela possui alunos.'
                ], 422); // 422 é um código de erro para "falha de validação"
            }
            // ***** FIM DA CORREÇÃO *****
            
            // Resposta antiga (fallback, caso não seja AJAX)
            return back()->withErrors(['error' => 'Não é possível excluir uma turma que possui alunos.']);
        }

        // 2. A lógica de exclusão está correta.
        $turma->delete();

        // ***** INÍCIO DA CORREÇÃO *****
        // Se for AJAX, retorna um JSON de sucesso
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Turma excluída com sucesso!'
            ]);
        }
        // ***** FIM DA CORREÇÃO *****

        // Resposta antiga (fallback)
        return redirect()->route('turmas.index')->with('success', 'Turma excluída com sucesso!');
    }
}