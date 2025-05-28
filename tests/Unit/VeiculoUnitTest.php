<?php

namespace Tests\Unit;

use App\Models\Veiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class VeiculoUnitTest extends TestCase
{
use RefreshDatabase;

    public function test_marca_valida_method(): void
    {
        $this->assertTrue(Veiculo::isMarcaValida('Ford'));
        $this->assertTrue(Veiculo::isMarcaValida('Honda'));
        $this->assertTrue(Veiculo::isMarcaValida('Toyota'));
        
        $this->assertFalse(Veiculo::isMarcaValida('MarcaInexistente'));
        $this->assertFalse(Veiculo::isMarcaValida('Forde'));
        $this->assertFalse(Veiculo::isMarcaValida('Volksvagen'));
    }

    public function test_decade_accessor(): void
    {
        $veiculo = new Veiculo(['ano' => 1995]);
        $this->assertEquals(1990, $veiculo->decada);

        $veiculo = new Veiculo(['ano' => 2003]);
        $this->assertEquals(2000, $veiculo->decada);

        $veiculo = new Veiculo(['ano' => 2019]);
        $this->assertEquals(2010, $veiculo->decada);

        $veiculo = new Veiculo(['ano' => 2024]);
        $this->assertEquals(2020, $veiculo->decada);
    }

    public function test_fillable_attributes(): void
    {
        $veiculo = new Veiculo();
        
        $expectedFillable = [
            'veiculo',
            'marca',
            'ano',
            'descricao',
            'cor',
            'vendido'
        ];

        $this->assertEquals($expectedFillable, $veiculo->getFillable());
    }

    public function test_casts(): void
    {
        $veiculo = new Veiculo();
        
        $expectedCasts = [
            'vendido' => 'boolean',
            'ano' => 'integer'
        ];

        $casts = $veiculo->getCasts();
        
        $this->assertEquals('boolean', $casts['vendido']);
        $this->assertEquals('integer', $casts['ano']);
    }

    public function test_marcas_validas_array(): void
    {
        $marcasValidas = Veiculo::$marcasValidas;
        
        $this->assertIsArray($marcasValidas);
        $this->assertNotEmpty($marcasValidas);
        
        $this->assertContains('Ford', $marcasValidas);
        $this->assertContains('Honda', $marcasValidas);
        $this->assertContains('Toyota', $marcasValidas);
        $this->assertContains('Volkswagen', $marcasValidas);
        $this->assertContains('Chevrolet', $marcasValidas);
        
        $this->assertNotContains('Forde', $marcasValidas);
        $this->assertNotContains('Volksvagen', $marcasValidas);
        $this->assertNotContains('Xevrolé', $marcasValidas);
    }

    public function test_table_name(): void
    {
        $veiculo = new Veiculo();
        $this->assertEquals('veiculos', $veiculo->getTable());
    }
}
