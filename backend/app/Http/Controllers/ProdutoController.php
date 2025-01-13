<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    public function index()
    {
        try {
            $produtos = Produto::with('categoria')->paginate(10);
            return response()->json([
                'success' => true,
                'data' => $produtos,
            ], 200);
        } catch (\Exception $e) {
            Log::error("Erro ao listar produtos: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar produtos. Tente novamente mais tarde.',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:50',
            'descricao' => 'required|max:200',
            'preco' => 'required|numeric|min:0',
            'data_validade' => 'required|date|after_or_equal:today',
            'imagem' => 'nullable|max:50',
            'categoria_id' => 'required|exists:categorias,id',
        ], [
            'nome.required' => 'O nome do produto é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'preco.required' => 'O preço é obrigatório.',
            'data_validade.required' => 'A data de validade é obrigatória.',
            'categoria_id.exists' => 'A categoria fornecida não existe.',
        ]);

        try {
            $fileName = null;
            if ($request->hasFile('imagem')) {
                $fileName = time() . '_' . $request->file('imagem')->getClientOriginalName();
                $request->file('imagem')->storeAs('produtos', $fileName, 'public');
            }

            $produto = Produto::create(array_merge($validated, ['imagem' => $fileName]));

            return response()->json([
                'success' => true,
                'data' => $produto,
            ], 201);
        } catch (\Exception $e) {
            Log::error("Erro ao criar produto: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar produto. Tente novamente mais tarde.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $produto = Produto::with('categoria')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $produto,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado.',
            ], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao exibir produto: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao exibir produto. Tente novamente mais tarde.',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required|max:50',
            'descricao' => 'required|max:200',
            'preco' => 'required|numeric|min:0',
            'data_validade' => 'required|date|after_or_equal:today',
            'imagem' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        try {
            $produto = Produto::findOrFail($id);

            $data = $validated;

            if ($request->hasFile('imagem')) {
                $fileName = time() . '_' . $request->file('imagem')->getClientOriginalName();
                $request->file('imagem')->storeAs('produtos', $fileName, 'public');
                $data['imagem'] = $fileName;
            }

            $produto->update($data);

            return response()->json([
                'success' => true,
                'data' => $produto,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado.',
            ], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar produto: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar produto. Tente novamente mais tarde.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $produto = Produto::findOrFail($id);
            $produto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produto deletado com sucesso.',
            ], 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado.',
            ], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao deletar produto: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar produto. Tente novamente mais tarde.',
            ], 500);
        }
    }
}
