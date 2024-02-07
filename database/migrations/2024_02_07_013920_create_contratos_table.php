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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->string('servico');
            $table->integer('contrato');
            $table->unsignedBigInteger('fk_empresa');
            $table->unsignedBigInteger('fk_unidade');
            $table->unsignedBigInteger('fk_fornecedor');
            $table->foreign('fk_empresa')->references('id')->on('empresas');
            $table->foreign('fk_unidade')->references('id')->on('unidades_consumidoras');
            $table->foreign('fk_fornecedor')->references('id')->on('fornecedores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
