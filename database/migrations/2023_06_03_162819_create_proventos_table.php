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
        Schema::create('proventos', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->foreignId('user_id');
            $table->foreignUuid('ativo_uid');
            $table->foreignUuid('tipo_provento_uid');
            $table->foreignUuid('corretora_uid');
            $table->date('data_com')->nullable();
            $table->date('data_pagamento');
            $table->double('quantidade_ativo');
            $table->double('valor');
            $table->double('yield_on_cost', 10, 2);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('ativo_uid')->references('uid')->on('ativos')->cascadeOnDelete();
            $table->foreign('tipo_provento_uid')->references('uid')->on('tipos_proventos')->cascadeOnDelete();
            $table->foreign('corretora_uid')->references('uid')->on('corretoras')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proventos');
    }
};
