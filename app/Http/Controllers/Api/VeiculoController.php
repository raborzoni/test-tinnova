<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VeiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Veiculo::query();

            $query->byMarca($request->marca)
                ->byAno($request->ano)
                ->byCor($request->cor);

            $veiculos = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $veiculos,
                'message' => 'Veículos listados com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar veículos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'veiculo' => 'required|string|max:255',
                'marca' => 'required|string|max:255',
                'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'descricao' => 'required|string',
                'cor' => 'nullable|string|max:255',
                'vendido' => 'boolean'
            ]);

            if (!Veiculo::isMarcaValida($validatedData['marca'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Marca não é válida',
                    'marcas_validas' => Veiculo::$marcasValidas
                ], 422);
            }

            $veiculo = Veiculo::create($validatedData);

            return response()->json([
                'success' => true,
                'data' => $veiculo,
                'message' => 'Veículo cadastrado com sucesso'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar veículo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $veiculo = Veiculo::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $veiculo,
                'message' => 'Veículo encontrado com sucesso'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar veículo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $veiculo = Veiculo::findOrFail($id);

            $validatedData = $request->validate([
                'veiculo' => 'required|string|max:255',
                'marca' => 'required|string|max:255',
                'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'descricao' => 'required|string',
                'cor' => 'nullable|string|max:255',
                'vendido' => 'boolean'
            ]);

            if (!Veiculo::isMarcaValida($validatedData['marca'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Marca não é válida',
                    'marcas_validas' => Veiculo::$marcasValidas
                ], 422);
            }

            $veiculo->update($validatedData);

            return response()->json([
                'success' => true,
                'data' => $veiculo->fresh(),
                'message' => 'Veículo atualizado com sucesso'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não encontrado'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar veículo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Partially update the specified resource in storage (PATCH).
     */
    public function patch(Request $request, string $id): JsonResponse
    {
        try {
            $veiculo = Veiculo::findOrFail($id);

            $validatedData = $request->validate([
                'veiculo' => 'sometimes|required|string|max:255',
                'marca' => 'sometimes|required|string|max:255',
                'ano' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
                'descricao' => 'sometimes|required|string',
                'cor' => 'sometimes|nullable|string|max:255',
                'vendido' => 'sometimes|boolean'
            ]);

            if (isset($validatedData['marca']) && !Veiculo::isMarcaValida($validatedData['marca'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Marca não é válida',
                    'marcas_validas' => Veiculo::$marcasValidas
                ], 422);
            }

            $veiculo->update($validatedData);

            return response()->json([
                'success' => true,
                'data' => $veiculo->fresh(),
                'message' => 'Veículo atualizado parcialmente com sucesso'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não encontrado'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar veículo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $veiculo = Veiculo::findOrFail($id);
            $veiculo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Veículo excluído com sucesso'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir veículo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get vehicles statistics by decade.
     */
    public function estatisticasPorDecada(): JsonResponse
    {
try {
            $totalVeiculos = Veiculo::count();
            
            if ($totalVeiculos === 0) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'Nenhum veículo cadastrado para estatísticas'
                ]);
            }

            $veiculos = Veiculo::select('ano')->get();
            
            $estatisticasPorDecada = [];
            
            foreach ($veiculos as $veiculo) {
                $decada = floor($veiculo->ano / 10) * 10;
                
                if (!isset($estatisticasPorDecada[$decada])) {
                    $estatisticasPorDecada[$decada] = 0;
                }
                
                $estatisticasPorDecada[$decada]++;
            }
            
            $estatisticas = collect($estatisticasPorDecada)
                ->map(function ($total, $decada) {
                    return [
                        'decada' => "Década {$decada}",
                        'total' => $total
                    ];
                })
                ->sortBy(function ($item) {
                    preg_match('/\d+/', $item['decada'], $matches);
                    return (int) $matches[0];
                })
                ->values();

            return response()->json([
                'success' => true,
                'data' => $estatisticas,
                'message' => 'Estatísticas por década obtidas com sucesso',
                'debug' => [
                    'total_veiculos' => $totalVeiculos,
                    'decadas_encontradas' => count($estatisticasPorDecada)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter estatísticas por década',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get vehicles statistics by manufacturer.
     */
    public function estatisticasPorFabricante(): JsonResponse
    {
        try {
            $estatisticas = Veiculo::select('marca')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('marca')
                ->orderBy('total', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $estatisticas,
                'message' => 'Estatísticas por fabricante obtidas com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter estatísticas por fabricante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get vehicles registered in the last week.
     */
    public function veiculosUltimaSemana(): JsonResponse
    {
        try {
            $veiculos = Veiculo::ultimaSemana()->get();

            return response()->json([
                'success' => true,
                'data' => $veiculos,
                'total' => $veiculos->count(),
                'message' => 'Veículos da última semana obtidos com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter veículos da última semana',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get valid brands.
     */
    public function marcasValidas(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Veiculo::$marcasValidas,
            'message' => 'Marcas válidas obtidas com sucesso'
        ]);
    }
}
