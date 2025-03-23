<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carteiras', function (Blueprint $table) {
            $table->uuid('uid')->primary()->index();
            $table->foreignId('user_id')->index();
            $table->foreignUuid('ativo_uid')->index();
            $table->double('quantidade');
            $table->double('preco_medio');
            $table->double('custo_total');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('ativo_uid')->references('uid')->on('ativos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carteiras');
    }
};
