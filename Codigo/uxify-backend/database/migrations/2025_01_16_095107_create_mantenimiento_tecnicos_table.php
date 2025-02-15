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
        Schema::create('mantenimiento_tecnicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_mantenimiento')->constrained('mantenimientos')->onDelete('cascade');
            $table->foreignId('id_tecnico')->constrained('users')->onDelete('cascade');

            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->string("comentario")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_tecnicos');
    }
};
