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
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo_maquina');
            $table->integer('prioridad');
            $table->integer('estado');

            $table->foreignId('id_section')->references('id')->on('sections')->onDelete('cascade');
            $table->boolean('desabilitado')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinas');
    }
};
