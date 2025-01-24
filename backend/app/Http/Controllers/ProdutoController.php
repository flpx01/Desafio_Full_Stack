<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Produto::with('categoria');

            // Adiciona suporte à busca por nome ou descrição
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('descricao', 'like', "%{$search}%");
            }

            $produtos = $query->paginate(10);

            // Adiciona o caminho completo às imagens
            foreach ($produtos->items() as $produto) {
                $produto->imagem = $produto->imagem 
                    ? asset('storage/produtos/' . $produto->imagem) 
                    : null;
            }

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

    // Mantendo os demais métodos como estão
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
    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'required|string',
        'preco' => 'required|numeric|min:0',
        'data_validade' => 'required|date',
        'categoria_id' => 'required|exists:categorias,id',
        'imagem' => 'nullable|file|image|max:2048', // Valida a imagem apenas se enviada
    ]);

    // Busca o produto pelo ID
    $produto = Produto::find($id);

    if (!$produto) {
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    // Atualiza os dados do produto
    $produto->nome = $request->input('nome');
    $produto->descricao = $request->input('descricao');
    $produto->preco = $request->input('preco');
    $produto->data_validade = $request->input('data_validade');
    $produto->categoria_id = $request->input('categoria_id');

    // Verifica se uma nova imagem foi enviada
    if ($request->hasFile('imagem')) {
        // Remove a imagem antiga, se existir
        if ($produto->imagem && file_exists(storage_path('app/public/' . $produto->imagem))) {
            unlink(storage_path('app/public/' . $produto->imagem));
        }

        // Gera um nome único para o arquivo com sua extensão original
        $extension = $request->file('imagem')->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;

        // Salva a nova imagem no diretório 'produtos'
        $path = $request->file('imagem')->storeAs('produtos', $filename, 'public');

        // Atualiza o caminho no banco de dados
        $produto->imagem = $path;
    }

    $produto->save();

    // Retorna o caminho completo da imagem para o frontend
    $produto->imagem = $produto->imagem ? asset('storage/' . $produto->imagem) : null;

    return response()->json([
        'message' => 'Produto atualizado com sucesso',
        'produto' => $produto
    ], 200);
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
