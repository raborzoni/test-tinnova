<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

    protected $fillable = [
        'veiculo',
        'marca',
        'ano',
        'descricao',
        'cor',
        'vendido'
    ];

    protected $casts = [
        'vendido' => 'boolean',
        'ano' => 'integer'
    ];

    public static $marcasValidas = [
        'Audi', 'BMW', 'Chevrolet', 'Citroën', 'Fiat', 'Ford', 'Honda', 
        'Hyundai', 'Jeep', 'Kia', 'Mitsubishi', 'Nissan', 'Peugeot', 
        'Renault', 'Toyota', 'Volkswagen', 'Volvo'
    ];

    public function scopeByMarca($query, $marca)
    {
        if ($marca) {
            return $query->where('marca', 'like', '%' . $marca . '%');
        }
        return $query;
    }

    public function scopeByAno($query, $ano)
    {
        if ($ano) {
            return $query->where('ano', $ano);
        }
        return $query;
    }

    public function scopeByCor($query, $cor)
    {
        if ($cor) {
            return $query->where('cor', 'like', '%' . $cor . '%');
        }
        return $query;
    }

    public function scopeUltimaSemana($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subWeek());
    }

    public function getDecadaAttribute()
    {
        return floor($this->ano / 10) * 10;
    }

    public static function isMarcaValida($marca)
    {
        return in_array($marca, self::$marcasValidas);
    }
}
