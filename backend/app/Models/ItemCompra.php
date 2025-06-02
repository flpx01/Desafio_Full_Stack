<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCompra extends Model
{
    use HasFactory;

    protected $table = 'itens_compra'; // 🔧 Corrige o nome da tabela

    protected $fillable = [
        'compra_id',
        'produto_id',
        'quantidade',
        'preco',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
