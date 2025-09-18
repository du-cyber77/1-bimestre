<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aluno>
 */
class AlunoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_caixa' => 'CX' . $this->faker->unique()->numberBetween(100, 999),
            'numero_pasta' => 'PA' . $this->faker->unique()->numberBetween(100, 999),
            'nome_aluno' => $this->faker->name(),
            'nome_responsavel' => $this->faker->name(),
            'data_nascimento' => $this->faker->date(),
            'obs' => $this->faker->sentence(),
            'turma_id' => \App\Models\Turma::inRandomOrder()->first()->id, 
        ];
    }
}


//php artisan migrate:fresh --seed

