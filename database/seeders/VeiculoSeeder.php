<?php

namespace Database\Seeders;

use App\Models\Veiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VeiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Veiculo::factory()->count(15)->decada(1990)->create();
        
        Veiculo::factory()->count(25)->decada(2000)->create();
        
        Veiculo::factory()->count(20)->decada(2010)->create();
        
        Veiculo::factory()->count(10)->decada(2020)->create();
        
        Veiculo::factory()->count(8)->marca('Ford')->create();
        Veiculo::factory()->count(12)->marca('Honda')->create();
        Veiculo::factory()->count(6)->marca('Toyota')->create();
        Veiculo::factory()->count(9)->marca('Volkswagen')->create();
        
        Veiculo::factory()->count(5)->vendido()->create();
        
        Veiculo::factory()->count(10)->disponivel()->create();
        
        Veiculo::factory()->count(3)->create([
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);
        
        Veiculo::factory()->count(2)->create([
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);
    }
}
