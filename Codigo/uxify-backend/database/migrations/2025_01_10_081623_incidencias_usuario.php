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
        Schema::create('incidencias_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incidencia_id');
            $table->foreignId('usuario_id');
            $table->date('fecha_inicio_reparacion');
            $table->date('fecha_fin_reparacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
