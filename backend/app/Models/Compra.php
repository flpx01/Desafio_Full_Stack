<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'forma_pagamento',
    ];

    // Relacionamento com o usuário (quem fez a compra)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento com os itens da compra
    public function itens()
    {
        return $this->hasMany(ItemCompra::class);
    }
}
