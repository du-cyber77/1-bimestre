<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        // Garanta que apenas esta linha está ativa.
        // As linhas antigas com Turma::create() devem estar apagadas ou comentadas.
        Turma::factory()->count(10)->create();
    }
}