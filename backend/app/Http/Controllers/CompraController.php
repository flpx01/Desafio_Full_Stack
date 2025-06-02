<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\ItemCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class CompraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'forma_pagamento' => 'required|string',
            'itens' => 'required|array|min:1',
            'itens.*.produto_id' => 'required|integer|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.preco' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $compra = Compra::create([
                'user_id' => Auth::id(),
                'total' => $request->total,
                'forma_pagamento' => $request->forma_pagamento,
            ]);

            foreach ($request->itens as $item) {
                ItemCompra::create([
                    'compra_id' => $compra->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco' => $item['preco'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Compra registrada com sucesso!',
                'compra_id' => $compra->id,
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar compra.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
