<?php // <-- Certifique-se que o arquivo começa com isso

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use App\Models\Turma;

class AlunoController extends Controller
{ // <-- Chave de abertura da CLASSE

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Parâmetros de ordenação (código que já tínhamos)
    $sort = $request->input('sort', 'id');
    $direction = $request->input('direction', 'asc');
    $allowedSorts = ['id', 'nome_aluno', 'data_nascimento'];
    if (!in_array($sort, $allowedSorts)) {
        $sort = 'id';
    }

    // Busca todas as turmas para popular o filtro no formulário
    $turmas = Turma::all();

    $query = Aluno::query();

    // FILTROS AVANÇADOS
    // Adiciona a condição do filtro de nome, se ele for preenchido
    if ($request->filled('filtro_nome')) {
        $query->where('nome_aluno', 'like', '%' . $request->input('filtro_nome') . '%');
    }

    // Adiciona a condição do filtro de responsável, se ele for preenchido
    if ($request->filled('filtro_responsavel')) {
        $query->where('nome_responsavel', 'like', '%' . $request->input('filtro_responsavel') . '%');
    }

    // Adiciona a condição do filtro de turma, se uma for selecionada
    if ($request->filled('filtro_turma_id')) {
        $query->where('turma_id', $request->input('filtro_turma_id'));
    }

    // Aplica a ordenação
    $query->orderBy($sort, $direction);

    // Pagina os resultados e anexa os parâmetros da busca/filtro/ordenação aos links da paginação
    $alunos = $query->paginate(10)->withQueryString();

    return view('alunos.index', compact('alunos', 'turmas', 'sort', 'direction'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $turmas = Turma::all(); // Busca todas as turmas
    return view('alunos.create', compact('turmas')); // Envia para a view
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // 1. Guarde os dados validados em uma variável
    $validatedData = $request->validate([
        'nome_aluno' => 'required|string|max:255',
        'nome_responsavel' => 'required|string|max:255',
        'numero_caixa' => 'required|string|max:50',
        'numero_pasta' => 'required|string|max:50',
        'data_nascimento' => 'required|date',
        'obs' => 'nullable|string',
        'turma_id' => 'nullable|exists:turmas,id' 
    ]);

    // 2. Passe APENAS os dados validados para o create()
    Aluno::create($validatedData);

    return redirect('/')->with('success', 'Aluno cadastrado com sucesso!');
}

    /**
     * Display the specified resource.
     */
    public function show(Aluno $aluno)
{
    // Graças ao Route Model Binding, o Laravel já encontrou o aluno
    // pelo ID na URL e o injetou aqui na variável $aluno.
    // Nós só precisamos retornar a view e passar o aluno para ela.
    return view('alunos.show', compact('aluno'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aluno $aluno)
    {
    $turmas = Turma::all(); // Busca todas as turmas
    return view('alunos.edit', compact('aluno', 'turmas')); // Envia para a view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
{
    // Valida os dados enviados pelo formulário
    $validatedData = $request->validate([
        'nome_aluno' => 'required|string|max:255',
        'nome_responsavel' => 'required|string|max:255',
        'numero_caixa' => 'required|string|max:50',
        'numero_pasta' => 'required|string|max:50',
        'data_nascimento' => 'required|date',
        'obs' => 'nullable|string',
        'turma_id' => 'nullable|exists:turmas,id' 
    ]);

    // Atualiza o registro do aluno com os dados validados
    $aluno->update($validatedData);

    return redirect('/')->with('success', 'Dados do aluno atualizados com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Aluno $aluno)
{
    // A variável $aluno já é o registro do aluno que queremos apagar
    $aluno->delete();

    // Redireciona de volta para a página inicial com uma mensagem de sucesso
    return redirect('/')->with('success', 'Aluno excluído com sucesso!');
}

} // <-- Chave de fechamento da CLASSE