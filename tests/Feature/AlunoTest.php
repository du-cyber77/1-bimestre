<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Turma;
use App\Models\Aluno;

class AlunoTest extends TestCase
{
    use RefreshDatabase; // Reseta o banco de dados a cada teste

    /** @test */
    public function um_usuario_pode_cadastrar_um_aluno()
    {
        // 1. Arrange (Preparar)
        // Cria uma turma para que possamos associar o aluno a ela
        $turma = Turma::factory()->create();

        // Dados do aluno que vamos tentar cadastrar
        $dadosAluno = [
            'nome_aluno' => 'João da Silva',
            'nome_responsavel' => 'Maria da Silva',
            'numero_caixa' => 'CX123',
            'numero_pasta' => 'PA456',
            'data_nascimento' => '2010-05-15',
            'turma_id' => $turma->id,
        ];

        // 2. Act (Agir)
        // Simula uma requisição POST para a rota de salvar aluno
        $response = $this->post(route('alunos.store'), $dadosAluno);

        // 3. Assert (Verificar)
        // Verifica se fomos redirecionados para a página inicial
        $response->assertRedirect('/');

        // Verifica se o aluno existe no banco de dados com os dados enviados
        $this->assertDatabaseHas('alunos', [
            'nome_aluno' => 'João da Silva',
            'data_nascimento' => '2010-05-15',
        ]);
    }

    /** @test */
    public function a_listagem_de_alunos_e_exibida_corretamente()
    {
        // Cria um aluno para o teste
        Aluno::factory()->create(['nome_aluno' => 'Aluno de Teste']);

        // Acessa a página inicial
        $response = $this->get('/');

        // Verifica se a página carregou com sucesso e se o nome do aluno aparece nela
        $response->assertStatus(200);
        $response->assertSee('Aluno de Teste');
    }
}