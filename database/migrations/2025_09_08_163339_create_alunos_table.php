<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_alunos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('alunos', function (Blueprint $table) {
        $table->id();
        $table->string('numero_caixa');
        $table->string('numero_pasta');
        $table->string('nome_aluno'); // <-- Confirme se esta linha está correta
        $table->string('nome_responsavel');
        $table->date('data_nascimento');
        $table->text('obs')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};