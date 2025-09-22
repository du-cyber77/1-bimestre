<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAlunoRequest;

class AlunoController extends Controller
{
    // O método index e search continuam os mesmos da busca dinâmica
    public function index(Request $request)
    {
        $turmas = Turma::orderBy('nome')->get();
        $alunos = Aluno::with('turma')->orderBy('nome_aluno', 'asc')->paginate(10);
        $totalAlunos = Aluno::count();
        $totalTurmas = Turma::count();
        $turmaMaisAlunos = Turma::withCount('alunos')->orderByDesc('alunos_count')->first();
        return view('alunos.index', compact('alunos', 'turmas', 'totalAlunos', 'totalTurmas', 'turmaMaisAlunos'));
    }

    public function search(Request $request)
    {
        $alunos = Aluno::with('turma')->nome($request->input('filtro_nome'))->responsavel($request->input('filtro_responsavel'))->turmaId($request->input('filtro_turma_id'))->orderBy('nome_aluno', 'asc')->get();
        return response()->json($alunos);
    }


    /**
     * ATUALIZADO: Retorna apenas a view do formulário para a modal.
     */
    public function create()
    {
        $turmas = Turma::orderBy('nome')->get();
        // Passamos um novo Aluno para o formulário não ter erros
        $aluno = new Aluno();
        return view('alunos._form', compact('aluno', 'turmas'));
    }

    /**
     * ATUALIZADO: Salva e retorna uma resposta JSON.
     */
    public function store(StoreAlunoRequest $request)
    {
        Aluno::create($request->validated());
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Aluno cadastrado com sucesso!']);
        }
        return redirect('/')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('aluno'));
    }

    /**
     * ATUALIZADO: Retorna apenas a view do formulário para a modal.
     */
    public function edit(Aluno $aluno)
    {
        $turmas = Turma::orderBy('nome')->get();
        return view('alunos._form', compact('aluno', 'turmas'));
    }

    /**
     * ATUALIZADO: Atualiza e retorna uma resposta JSON.
     */
    public function update(StoreAlunoRequest $request, Aluno $aluno)
    {
        $aluno->update($request->validated());
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Dados do aluno atualizados com sucesso!']);
        }
        return redirect('/')->with('success', 'Dados do aluno atualizados com sucesso!');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();
        return redirect('/')->with('success', 'Aluno excluído com sucesso!');
    }
}