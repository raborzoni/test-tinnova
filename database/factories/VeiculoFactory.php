<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Veiculo;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Veiculo>
 */
class VeiculoFactory extends Factory
{

    protected $model = Veiculo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modelos = [
            'Civic', 'Corolla', 'Focus', 'Golf', 'Fiesta', 'Uno', 'Gol', 'Palio',
            'Sandero', 'HB20', 'Onix', 'Ka', 'Celta', 'Classic', 'Prisma'
        ];

        $cores = [
            'Branco', 'Preto', 'Prata', 'Vermelho', 'Azul', 'Cinza', 'Bege',
            'Verde', 'Amarelo', 'Dourado', 'Bordô', 'Rosa', 'Roxo'
        ];

        return [
            'veiculo' => $this->faker->randomElement($modelos),
            'marca' => $this->faker->randomElement(Veiculo::$marcasValidas),
            'ano' => $this->faker->numberBetween(1990, 2024),
            'descricao' => $this->faker->paragraph(2),
            'cor' => $this->faker->randomElement($cores),
            'vendido' => $this->faker->boolean(30), 
        ];
    }

    /**
     * Indicate that the vehicle is sold.
     */
    public function vendido(): static
    {
        return $this->state(fn (array $attributes) => [
            'vendido' => true,
        ]);
    }

    /**
     * Indicate that the vehicle is not sold.
     */
    public function disponivel(): static
    {
        return $this->state(fn (array $attributes) => [
            'vendido' => false,
        ]);
    }

    /**
     * Create a vehicle from a specific decade.
     */
    public function decada(int $decada): static
    {
        return $this->state(fn (array $attributes) => [
            'ano' => $this->faker->numberBetween($decada, $decada + 9),
        ]);
    }

    /**
     * Create a vehicle from a specific brand.
     */
    public function marca(string $marca): static
    {
        return $this->state(fn (array $attributes) => [
            'marca' => $marca,
        ]);
    }
}
