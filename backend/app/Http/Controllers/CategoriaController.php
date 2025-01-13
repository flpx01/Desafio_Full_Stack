<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CategoriaController extends Controller
{
    public function index()
    {
        try {
            $categorias = Categoria::all();
            return response()->json([
                'success' => true,
                'data' => $categorias,
            ], 200);
        } catch (Exception $e) {
            Log::error("Erro ao listar categorias: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar categorias. Tente novamente mais tarde.',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        try {
            $categoria = Categoria::create($validated);
            return response()->json([
                'success' => true,
                'data' => $categoria,
            ], 201);
        } catch (Exception $e) {
            Log::error("Erro ao criar categoria: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar categoria. Tente novamente mais tarde.',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $categoria,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);
        } catch (Exception $e) {
            Log::error("Erro ao exibir categoria: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao exibir categoria. Tente novamente mais tarde.',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->update($validated);

            return response()->json([
                'success' => true,
                'data' => $categoria,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);
        } catch (Exception $e) {
            Log::error("Erro ao atualizar categoria: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar categoria. Tente novamente mais tarde.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categoria deletada com sucesso.',
            ], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);
        } catch (Exception $e) {
            Log::error("Erro ao deletar categoria: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar categoria. Tente novamente mais tarde.',
            ], 500);
        }
    }
}
