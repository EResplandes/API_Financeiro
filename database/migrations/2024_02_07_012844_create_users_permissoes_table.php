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
        Schema::create('users_permissoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_usuario');
            $table->unsignedBigInteger('fk_permissao');
            $table->foreign('fk_usuario')->references('id')->on('users');
            $table->foreign('fk_permissao')->references('id')->on('permissoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_permissoes');
    }
};
