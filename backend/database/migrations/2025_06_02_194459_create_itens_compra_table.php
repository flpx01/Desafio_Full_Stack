<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('itens_compra', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('compra_id');
        $table->unsignedBigInteger('produto_id');
        $table->integer('quantidade');
        $table->decimal('preco', 10, 2);
        $table->timestamps();

        $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
        $table->foreign('produto_id')->references('id')->on('produtos');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_compra');
    }
};
