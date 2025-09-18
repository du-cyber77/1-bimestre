<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Garanta que esta seção de "call" esteja correta.
        // O TurmaSeeder PRECISA vir antes do AlunoSeeder.
        $this->call([
            TurmaSeeder::class,
            AlunoSeeder::class,
        ]);
    }
}