<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('linhas_arquivo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arquivo_id')->constrained('arquivos')->onDelete('cascade');

            // colunas que você já tem no CSV
            $table->string('rptdt')->nullable();
            $table->string('tckrsymb')->nullable();
            $table->string('mktnm')->nullable();
            $table->string('sctyctgynm')->nullable();
            $table->string('isin')->nullable();
            $table->string('crpnnm')->nullable();

            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('linhas_arquivo');
    }
};
