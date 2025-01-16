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
        Schema::create('incidencia_tecnicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_incidencia')->constrained('incidencias')->onDelete('cascade');
            $table->foreignId('id_tecnico')->constrained('users')->onDelete('cascade');

            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencia_tecnicos');
    }
};
