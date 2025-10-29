<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAlunoRequest;

class AlunoController extends Controller
{
    /**
     * ATUALIZADO: Unifica a listagem e a busca.
     * Responde a requisições normais (HTML) e AJAX (JSON) de filtro.
     */
    public function index(Request $request)
    {
        // 1. Inicia a query com os filtros
        $query = Aluno::with('turma')
            ->nome($request->input('filtro_nome'))
            ->responsavel($request->input('filtro_responsavel'))
            ->turmaId($request->input('filtro_turma_id'))
            ->orderBy('nome_aluno', 'asc');

        // 2. Pagina os resultados E mantém os filtros na URL da paginação
        $alunos = $query->paginate(10)->withQueryString();

        // 3. Verifica se é a requisição AJAX do formulário de filtro
        if ($request->ajax()) {
            return response()->json([
                'lista' => view('alunos._lista', compact('alunos'))->render(),
                'paginacao' => $alunos->links()->toHtml(),
            ]);
        }

        // 4. Se for a carga inicial da página, carrega todos os dados
        $turmas = Turma::orderBy('nome')->get();
        $totalAlunos = Aluno::count();
        $totalTurmas = Turma::count();
        $turmaMaisAlunos = Turma::withCount('alunos')->orderByDesc('alunos_count')->first();

        return view('alunos.index', compact(
            'alunos', 'turmas', 'totalAlunos', 'totalTurmas', 'turmaMaisAlunos'
        ));
    }

    /**
     * NOVO: Carrega o formulário de criação para a modal.
     */
    public function createModal()
    {
        $turmas = Turma::orderBy('nome')->get();
        $aluno = new Aluno(); // Objeto vazio para o formulário
        return view('alunos._form', compact('aluno', 'turmas'));
    }

    /**
     * NOVO: Carrega o formulário de edição para a modal.
     */
    public function editModal(Aluno $aluno)
    {
        $turmas = Turma::orderBy('nome')->get();
        return view('alunos._form', compact('aluno', 'turmas'));
    }

    /**
     * ATUALIZADO: Salva e retorna JSON com a lista atualizada.
     * Removemos a verificação `if (ajax)`.
     */
    public function store(StoreAlunoRequest $request)
    {
        Aluno::create($request->validated());
        
        // Retorna uma resposta JSON com a lista de alunos atualizada
        $alunos = Aluno::with('turma')->orderBy('nome_aluno', 'asc')->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Aluno cadastrado com sucesso!',
            'lista' => view('alunos._lista', compact('alunos'))->render(),
            'paginacao' => $alunos->links()->toHtml(),
        ]);
    }

    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('aluno'));
    }

    /**
     * ATUALIZADO: Atualiza e retorna JSON com a lista atualizada.
     * Removemos a verificação `if (ajax)`.
     */
    public function update(StoreAlunoRequest $request, Aluno $aluno)
    {
        $aluno->update($request->validated());

        // Retorna uma resposta JSON com a lista de alunos atualizada
        // (Idealmente, deveria respeitar os filtros atuais, mas vamos simplificar)
        $alunos = Aluno::with('turma')->orderBy('nome_aluno', 'asc')->paginate(10);
        
        return response()->json([
            'success' => true,
            'message' => 'Dados do aluno atualizados com sucesso!',
            'lista' => view('alunos._lista', compact('alunos'))->render(),
            'paginacao' => $alunos->links()->toHtml(),
        ]);
    }

    /**
     * ATUALIZADO: Exclui e retorna JSON com a lista atualizada.
     */
    public function destroy(Request $request, Aluno $aluno)
    {
        $aluno->delete();

        // Recarrega a lista da página correta
        // Se a última página ficou vazia, volta para a anterior
        $page = $request->input('page', 1);
        $alunos = Aluno::with('turma')->orderBy('nome_aluno', 'asc')->paginate(10, ['*'], 'page', $page);
        
        // Se a página atual ficou vazia após a exclusão, busca a última página válida
        if ($alunos->isEmpty() && $page > 1) {
             $alunos = Aluno::with('turma')->orderBy('nome_aluno', 'asc')->paginate(10, ['*'], 'page', $alunos->lastPage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Aluno excluído com sucesso!',
            'lista' => view('alunos._lista', compact('alunos'))->render(),
            'paginacao' => $alunos->links()->toHtml(),
        ]);
    }

    // Os métodos create() e edit() não são mais necessários
    // O método search() foi mesclado ao index()
}