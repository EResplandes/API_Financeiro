<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fornecedor>
 */
class FornecedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->text,
            'nome_fantasia' => $this->faker->date,
            'cnpj' => $this->faker->randomNumber(9, true),
            'login' => $this->faker->text,
            'senha' => $this->faker->text,
            'fk_banco' => 1,
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date
        ];
    }
}
