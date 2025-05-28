<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;

class WebController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function veiculos()
    {
        $marcasValidas = Veiculo::$marcasValidas;
        return view('veiculos.index', compact('marcasValidas'));
    }

    public function estatisticas()
    {
        return view('estatisticas.index');
    }
}
