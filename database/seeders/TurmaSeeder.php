<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma; // Importe o Model

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        Turma::create(['nome' => 'Turma 101']);
        Turma::create(['nome' => 'Turma 201']);
        Turma::create(['nome' => 'Turma 301']);
    }
}