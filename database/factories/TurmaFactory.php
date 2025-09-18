<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TurmaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Gera um nome como "Turma 123". O unique() garante que o número não se repita.
            'nome' => 'Turma ' . $this->faker->unique()->numberBetween(100, 399),
        ];
    }
}