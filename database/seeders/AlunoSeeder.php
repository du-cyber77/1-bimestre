<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aluno; // <-- Verifique se esta linha de importação existe

class AlunoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Esta linha executa a criação dos 50 alunos.
        Aluno::factory(50)->create(); 
    }
}