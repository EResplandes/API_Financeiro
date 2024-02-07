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
        Schema::create('historico_parcelas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_status');
            $table->unsignedBigInteger('fk_parcela');
            $table->unsignedBigInteger('fk_status');
            $table->foreign('fk_parcela')->references('id')->on('parcelas');
            $table->foreign('fk_status')->references('id')->on('status_parcelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_parcelas');
    }
};
