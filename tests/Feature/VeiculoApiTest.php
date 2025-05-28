<?php

namespace Tests\Feature;

use App\Models\Veiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VeiculoApiTest extends TestCase
{
use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Veiculo::factory()->count(10)->create();
    }

    public function test_can_list_all_veiculos(): void
    {
        $response = $this->getJson('/api/v1/veiculos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'veiculo',
                        'marca',
                        'ano',
                        'descricao',
                        'cor',
                        'vendido',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'message'
            ])
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_can_filter_veiculos_by_marca(): void
    {
        $veiculo = Veiculo::factory()->create(['marca' => 'Ford']);

        $response = $this->getJson('/api/v1/veiculos?marca=Ford');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $data = $response->json('data');
        $this->assertNotEmpty($data);
        $this->assertEquals('Ford', $data[0]['marca']);
    }

    public function test_can_filter_veiculos_by_ano(): void
    {
        $veiculo = Veiculo::factory()->create(['ano' => 2020]);

        $response = $this->getJson('/api/v1/veiculos?ano=2020');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $data = $response->json('data');
        $this->assertNotEmpty($data);
        $this->assertEquals(2020, $data[0]['ano']);
    }

    public function test_can_create_veiculo(): void
    {
        $veiculoData = [
            'veiculo' => 'Civic',
            'marca' => 'Honda',
            'ano' => 2022,
            'descricao' => 'Veículo em excelente estado',
            'cor' => 'Preto',
            'vendido' => false
        ];

        $response = $this->postJson('/api/v1/veiculos', $veiculoData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Veículo cadastrado com sucesso'
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'veiculo',
                    'marca',
                    'ano',
                    'descricao',
                    'cor',
                    'vendido'
                ]
            ]);

        $this->assertDatabaseHas('veiculos', [
            'veiculo' => 'Civic',
            'marca' => 'Honda',
            'ano' => 2022
        ]);
    }

    public function test_cannot_create_veiculo_with_invalid_marca(): void
    {
        $veiculoData = [
            'veiculo' => 'Civic',
            'marca' => 'MarcaInvalida',
            'ano' => 2022,
            'descricao' => 'Veículo em excelente estado',
            'cor' => 'Preto',
            'vendido' => false
        ];

        $response = $this->postJson('/api/v1/veiculos', $veiculoData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Marca não é válida'
            ]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/v1/veiculos', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos'
            ])
            ->assertJsonValidationErrors(['veiculo', 'marca', 'ano', 'descricao']);
    }

    public function test_can_show_veiculo(): void
    {
        $veiculo = Veiculo::factory()->create();

        $response = $this->getJson("/api/v1/veiculos/{$veiculo->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $veiculo->id,
                    'veiculo' => $veiculo->veiculo,
                    'marca' => $veiculo->marca
                ]
            ]);
    }

    public function test_returns_404_for_nonexistent_veiculo(): void
    {
        $response = $this->getJson('/api/v1/veiculos/999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Veículo não encontrado'
            ]);
    }

    public function test_can_update_veiculo_with_put(): void
    {
        $veiculo = Veiculo::factory()->create();

        $updateData = [
            'veiculo' => 'Corolla Updated',
            'marca' => 'Toyota',
            'ano' => 2023,
            'descricao' => 'Descrição atualizada',
            'cor' => 'Branco',
            'vendido' => true
        ];

        $response = $this->putJson("/api/v1/veiculos/{$veiculo->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Veículo atualizado com sucesso'
            ]);

        $this->assertDatabaseHas('veiculos', [
            'id' => $veiculo->id,
            'veiculo' => 'Corolla Updated',
            'marca' => 'Toyota',
            'vendido' => true
        ]);
    }

    public function test_can_partially_update_veiculo_with_patch(): void
    {
        $veiculo = Veiculo::factory()->create();

        $updateData = [
            'vendido' => true,
            'cor' => 'Azul'
        ];

        $response = $this->patchJson("/api/v1/veiculos/{$veiculo->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Veículo atualizado parcialmente com sucesso'
            ]);

        $this->assertDatabaseHas('veiculos', [
            'id' => $veiculo->id,
            'vendido' => true,
            'cor' => 'Azul',
            'veiculo' => $veiculo->veiculo, 
            'marca' => $veiculo->marca 
        ]);
    }

    public function test_can_delete_veiculo(): void
    {
        $veiculo = Veiculo::factory()->create();

        $response = $this->deleteJson("/api/v1/veiculos/{$veiculo->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Veículo excluído com sucesso'
            ]);

        $this->assertDatabaseMissing('veiculos', [
            'id' => $veiculo->id
        ]);
    }

    public function test_can_get_estatisticas_por_decada(): void
    {
        Veiculo::factory()->create(['ano' => 1995]);
        Veiculo::factory()->create(['ano' => 1998]);
        Veiculo::factory()->create(['ano' => 2005]);
        Veiculo::factory()->create(['ano' => 2015]);

        $response = $this->getJson('/api/v1/veiculos/estatisticas/decadas');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'decada',
                        'total'
                    ]
                ]
            ]);
    }

    public function test_can_get_estatisticas_por_fabricante(): void
    {
        Veiculo::factory()->count(3)->create(['marca' => 'Ford']);
        Veiculo::factory()->count(2)->create(['marca' => 'Honda']);

        $response = $this->getJson('/api/v1/veiculos/estatisticas/fabricantes');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'marca',
                        'total'
                    ]
                ]
            ]);
    }

    public function test_can_get_veiculos_ultima_semana(): void
    {
        Veiculo::factory()->create([
            'created_at' => now()->subDays(3)
        ]);

        Veiculo::factory()->create([
            'created_at' => now()->subDays(10)
        ]);

        $response = $this->getJson('/api/v1/veiculos/ultima-semana');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'data',
                'total'
            ]);

        $this->assertGreaterThanOrEqual(1, $response->json('total'));
    }

    public function test_can_get_marcas_validas(): void
    {
        $response = $this->getJson('/api/v1/veiculos/marcas-validas');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => Veiculo::$marcasValidas
            ]);
    }

    public function test_year_validation(): void
    {
        $veiculoData = [
            'veiculo' => 'Civic',
            'marca' => 'Honda',
            'ano' => 1800, 
            'descricao' => 'Veículo em excelente estado',
            'cor' => 'Preto',
            'vendido' => false
        ];

        $response = $this->postJson('/api/v1/veiculos', $veiculoData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['ano']);
    }

    public function test_future_year_validation(): void
    {
        $futureYear = date('Y') + 5;
        
        $veiculoData = [
            'veiculo' => 'Civic',
            'marca' => 'Honda',
            'ano' => $futureYear,
            'descricao' => 'Veículo em excelente estado',
            'cor' => 'Preto',
            'vendido' => false
        ];

        $response = $this->postJson('/api/v1/veiculos', $veiculoData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['ano']);
    }

    public function test_can_filter_by_multiple_parameters(): void
    {
        $veiculo = Veiculo::factory()->create([
            'marca' => 'Ford',
            'ano' => 2020,
            'cor' => 'Vermelho'
        ]);

        $response = $this->getJson('/api/v1/veiculos?marca=Ford&ano=2020&cor=Vermelho');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $data = $response->json('data');
        $this->assertNotEmpty($data);
        
        $foundVeiculo = collect($data)->first(function ($item) use ($veiculo) {
            return $item['id'] === $veiculo->id;
        });
        
        $this->assertNotNull($foundVeiculo);
        $this->assertEquals('Ford', $foundVeiculo['marca']);
        $this->assertEquals(2020, $foundVeiculo['ano']);
        $this->assertEquals('Vermelho', $foundVeiculo['cor']);
    }
}
