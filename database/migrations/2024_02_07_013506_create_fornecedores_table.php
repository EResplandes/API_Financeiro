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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->uniqid();
            $table->string('nome_fantasia')->uniqid();
            $table->string('cnpj')->uniqid();
            $table->string('login')->nullable();
            $table->string('senha')->nullable();
            $table->unsignedBigInteger('fk_banco');
            $table->foreign('fk_banco')->references('id')->on('dados_bancarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
