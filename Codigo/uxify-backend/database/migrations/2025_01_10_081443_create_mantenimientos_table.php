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
        Schema::create('mantenimientos_preventivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_maquina')->constrained('maquinas');
            $table->date('duracion')->nullable();
            $table->date('fecha_inicio');
            $table->date('proxima_fecha')->nullable();
            $table->foreignId('id_usuario')->nullable()->constrained('users');
            $table->string('descripcion')->nullable();
            $table->string('periodo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
