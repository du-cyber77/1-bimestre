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
        // Esta linha é a mais importante.
        // Se ela estiver faltando ou comentada, nada acontece.
        $this->call([
            AlunoSeeder::class,
        ]); 
    }
}