<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
public function up(): void
{
    Schema::table('alunos', function (Blueprint $table) {
        $table->foreignId('turma_id') // Cria a coluna turma_id
              ->nullable()           // Permite que o valor seja nulo
              ->constrained('turmas') // Define que é uma chave estrangeira da tabela 'turmas'
              ->onDelete('set null'); // Se uma turma for deletada, o campo no aluno vira nulo
    });
}


public function down(): void
{
    Schema::table('alunos', function (Blueprint $table) {
        $table->dropForeign(['turma_id']);
        $table->dropColumn('turma_id');
    });
}
};
