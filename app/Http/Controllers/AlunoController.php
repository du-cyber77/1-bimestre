<?php // <-- Certifique-se que o arquivo começa com isso

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{ // <-- Chave de abertura da CLASSE

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { // <-- Chave de abertura da função index
        $query = Aluno::query();

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('nome_aluno', 'like', "%{$search}%")
                  ->orWhere('numero_caixa', 'like', "%{$search}%")
                  ->orWhere('numero_pasta', 'like', "%{$search}%");
        }

        $alunos = $query->paginate(10);

        return view('alunos.index', compact('alunos'));
    } // <-- Chave de fechamento da função index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { // <-- Chave de abertura da função create
        return view('alunos.create');
    } // <-- Chave de fechamento da função create

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aluno $aluno)
{
    // Retorna a view de edição, passando os dados do aluno que será editado
    return view('alunos.edit', compact('aluno'));
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

} // <-- A CHAVE MAIS IMPORTANTE: fechamento da CLASSE